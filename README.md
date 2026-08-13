# WordPress Post Shortlink Copy

A lightweight WordPress plugin that displays a shortlink field with a copy button at the end of single blog posts.

## Features

- Displays only on single `post` pages
- Uses WordPress `wp_get_shortlink()` with the canonical permalink as fallback
- Appends the box only to the main content loop
- One-click copy using the Clipboard API
- Clipboard fallback for unsupported or restricted browsers
- Responsive minimal UI
- Scoped CSS and JavaScript
- No settings page, custom database table, post meta, or external dependency
- Translation-ready

## Requirements

- WordPress 6.0+
- PHP 7.4+

## Installation

1. Upload the `WordPress-Post-Shortlink-Copy` folder to `/wp-content/plugins/`.
2. Activate **WordPress Post Shortlink Copy** from the Plugins screen.

## How It Works

The plugin hooks into `the_content` and appends a shortlink field after the main content on single blog posts.

It first requests the WordPress shortlink for the current post. If WordPress does not provide one, the normal permalink is displayed instead.

Frontend CSS and JavaScript load only on single post pages.

## Data Storage

This plugin does not store custom data.

## Compatibility

- WordPress 6.0+
- PHP 7.4+
- Classic and block themes that render the main post content through `the_content`
- No WooCommerce dependency
- Does not create a URL-shortening service or change permalink structure

## License

GPL-3.0

## Author

Amirreza Shayesteh Far  
https://github.com/amirrezashf

---

# کپی لینک کوتاه نوشته در وردپرس

افزونه‌ای سبک برای نمایش لینک کوتاه نوشته به همراه دکمه کپی در انتهای محتوای نوشته‌های تکی وردپرس.

## قابلیت‌ها

- نمایش فقط در صفحات تکی نوشته‌ها
- استفاده از `wp_get_shortlink()` و پیوند یکتای اصلی به‌عنوان جایگزین
- اضافه شدن فقط به محتوای اصلی نوشته
- کپی لینک با Clipboard API
- روش جایگزین برای مرورگرهای فاقد دسترسی مناسب به Clipboard API
- رابط کاربری مینیمال و واکنش‌گرا
- CSS و JavaScript محدود به خود افزونه
- بدون صفحه تنظیمات، جدول دیتابیس یا متادیتای اختصاصی
- آماده ترجمه

## نیازمندی‌ها

- WordPress 6.0+
- PHP 7.4+

## نصب

1. پوشه `WordPress-Post-Shortlink-Copy` را در `/wp-content/plugins/` قرار دهید.
2. افزونه **WordPress Post Shortlink Copy** را فعال کنید.

## نحوه عملکرد

افزونه با فیلتر `the_content` در انتهای محتوای اصلی نوشته‌های تکی، لینک کوتاه و دکمه کپی را نمایش می‌دهد.

اگر وردپرس برای نوشته لینک کوتاه ارائه نکند، پیوند یکتای اصلی نوشته نمایش داده می‌شود.

CSS و JavaScript فقط در صفحات تکی نوشته‌ها بارگذاری می‌شوند.

## ذخیره‌سازی داده

این افزونه هیچ داده اختصاصی در دیتابیس ذخیره نمی‌کند.

## سازگاری

- WordPress 6.0+
- PHP 7.4+
- قالب‌های کلاسیک و بلوکی که محتوای اصلی را با `the_content` نمایش می‌دهند
- بدون وابستگی به WooCommerce
- بدون تغییر ساختار Permalink و بدون ایجاد سرویس کوتاه‌کننده URL

## مجوز

GPL-3.0

## نویسنده

Amirreza Shayesteh Far  
https://github.com/amirrezashf
