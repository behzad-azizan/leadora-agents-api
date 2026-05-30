# leadora/agents-api

کلاینت PHP برای API پنل نمایندگی لیدورا.

## نصب

```bash
composer require leadora/agents-api
```

توسعه محلی:

```json
{
    "repositories": [
        {
            "type": "path",
            "url": "/home/behzad/Documents/php-projects/leadora-agents-api"
        }
    ],
    "require": {
        "leadora/agents-api": "@dev"
    }
}
```

## راه‌اندازی

```php
use Leadora\Agents\LeadoraClient;

$client = LeadoraClient::create(
    baseUrl: env('LEADORA_BASE_URL'),
    apiToken: env('LEADORA_API_TOKEN'),
);

// endpointهای پنل (غیر از ثبت/لیست کاربر و /me) نیاز به X-User-Id دارند
$user = $client->forUser($leadoraUserId);
```

## فهرست endpointها

| متد کلاینت | HTTP | نیاز به `X-User-Id` |
|------------|------|---------------------|
| `agent()->me()` | `GET /me` | خیر |
| `users()->register()` | `POST /v1/users` | خیر |
| `users()->list()` | `GET /v1/users` | خیر |
| `users()->get()` / `update()` | `GET/PATCH /v1/users/{id}` | بله |
| `profile()->get()` | `GET /v1/profile` | بله |
| `geo()->provinces()` | `GET /v1/geo/provinces` | بله |
| `geo()->cities($provinceId)` | `GET /v1/geo/cities` | بله |
| `operators()->list()` | `GET /v1/operators` | بله |
| `genders()->list()` | `GET /v1/genders` | بله |
| `leads()->filterPreview()` | `POST /v1/leads/filter-preview` | بله |
| `pricing()->quote()` | `POST /v1/pricing/quote` | بله |
| `leadRequests()->create()` | `POST /v1/lead-requests` | بله |
| `leadRequests()->pay($publicId)` | `POST /v1/lead-requests/{id}/pay` | بله |

## ۱. ثبت کاربر بعد از signup

```php
use Leadora\Agents\Users\RegisterUserRequest;

$registration = $client->users()->register(new RegisterUserRequest(
    mobile: $user->mobile,
    agentUniqueId: (string) $user->id,
    firstName: $user->first_name,
    lastName: $user->last_name,
));

$leadoraUserId = $registration->id;
```

## ۲. داده‌های مرجع (استان، شهر، اپراتور، جنسیت)

```php
$user = $client->forUser($leadoraUserId);

$provinces = $user->geo()->provinces();
$cities = $user->geo()->cities(provinceId: 8);

$operators = $user->operators()->list();
$genders = $user->genders()->list();
```

## ۳. پیش‌نمایش فیلتر و محاسبه قیمت

```php
use Leadora\Agents\Filters\LeadStructuredFilters;
use Leadora\Agents\Leads\LeadFilterPreviewRequest;
use Leadora\Agents\Pricing\PricingQuoteRequest;

$filters = new LeadStructuredFilters(
    provinceIds: [8],
    cityIds: [301],
    genders: ['male'],
    operators: ['irancell'],
);

$preview = $user->leads()->filterPreview(new LeadFilterPreviewRequest(
    filters: $filters,
    countMode: 'exact',
));

$resolved = $preview->resolvedStructuredFilters;

$quote = $user->pricing()->quote(new PricingQuoteRequest(
    filters: $resolved,
    withCount: true,
    countMode: $preview->countMode,
));
```

پیش‌نمایش با متن طبیعی:

```php
$preview = $user->leads()->filterPreview(new LeadFilterPreviewRequest(
    naturalLanguageIntent: 'مردان ۲۵ تا ۴۰ سال در تهران، ایرانسل',
));
```

## ۴. ثبت و پرداخت درخواست لید

```php
use Leadora\Agents\LeadRequests\LeadRequestCreate;

$result = $user->leadRequests()->create(new LeadRequestCreate(
    filters: $resolved,
    requestedQuantity: 5000,
    countMode: 'exact',
));

$publicId = $result->request->publicId;

$paid = $user->leadRequests()->pay($publicId);
```

## خطاها

```php
use Leadora\Agents\Exception\ApiException;

try {
    $user->leadRequests()->pay($publicId);
} catch (ApiException $e) {
    // $e->errorCode مثلاً insufficient_wallet_balance
}
```

## هدرها

| هدر | معنی |
|-----|------|
| `X-API-Token` | توکن نماینده (`{token_id}.{secret}`) |
| `X-User-Id` | شناسه کاربر زیرمجموعه (`users.id`) |
