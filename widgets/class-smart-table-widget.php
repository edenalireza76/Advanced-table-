<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;

class MoghimWP_Smart_Table_Widget extends Widget_Base {

	public function get_name() {
		return 'moghimwp_smart_table';
	}

	public function get_title() {
		return 'جدول قیمت هوشمند (مقیم وردپرس)';
	}

	public function get_icon() {
		return 'eicon-table';
	}

	public function get_categories() {
		return [ 'general' ];
	}

	public function get_keywords() {
		return [ 'table', 'price', 'implant', 'جدول', 'قیمت', 'ایمپلنت', 'تب', 'مقیم' ];
	}

	public function get_style_depends() {
		return [ 'moghimwp-smart-table-css' ];
	}

	public function get_script_depends() {
		return [ 'moghimwp-smart-table-js' ];
	}

	/**
	 * لیست آماده کشورها با پرچم برای انتخاب سریع کاربر
	 */
	private function get_countries_list() {
		return [
			'🇰🇷 کره‌ای'                        => '🇰🇷 کره‌ای',
			'🇩🇪 آلمانی'                        => '🇩🇪 آلمانی',
			'🇨🇭 سوئیسی'                        => '🇨🇭 سوئیسی',
			'🇺🇸 آمریکایی'                      => '🇺🇸 آمریکایی',
			'🇨🇭 گروه اشترومن (تولید برزیل)'    => '🇨🇭 گروه اشترومن (تولید برزیل)',
			'🇰🇷 ایمپلنت کره‌ای'                => '🇰🇷 ایمپلنت کره‌ای',
			'🇩🇪 ایمپلنت آلمانی'                => '🇩🇪 ایمپلنت آلمانی',
			'🇨🇭 ایمپلنت سوئیسی'                => '🇨🇭 ایمپلنت سوئیسی',
			'🇺🇸 ایمپلنت آمریکایی'              => '🇺🇸 ایمپلنت آمریکایی',
			'🇫🇷 فرانسوی'                       => '🇫🇷 فرانسوی',
			'🇪🇸 اسپانیایی'                     => '🇪🇸 اسپانیایی',
			'🇮🇹 ایتالیایی'                     => '🇮🇹 ایتالیایی',
			'🇸🇪 سوئدی'                         => '🇸🇪 سوئدی',
			'🇧🇷 برزیلی'                        => '🇧🇷 برزیلی',
			'🇮🇷 ایرانی'                        => '🇮🇷 ایرانی',
			'custom'                           => '✏️ متن دلخواه (وارد کردن دستی)',
		];
	}

	/**
	 * داده‌های پیش‌فرض تمام ۱۰ جدول موجود در فایل HTML
	 */
	private function get_presets_data() {
		return [
			'brands' => [
				'title'   => '۱. جدول قیمت پایه بر اساس برند (۴ ستونه + تب فیلتر)',
				'cols'    => 4,
				'tabs'    => true,
				'headers' => [ 'برند', 'کشور / دسته', 'رده', 'قیمت پایه' ],
				'caption' => 'برندهای موجود در کلینیک و قیمت قطعی هر برند پس از معاینه اعلام می‌شود.',
				'rows'    => [
					[ 'row_filter_keys' => 'kr std', 'col1_text' => 'مگاژن (Megagen)', 'col2_type' => 'country', 'col2_country' => '🇰🇷 کره‌ای', 'col3_type' => 'pill_std', 'col3_text' => 'استاندارد', 'col4_type' => 'price', 'col4_text' => '۳۲٬۵۰۰٬۰۰۰ تومان' ],
					[ 'row_filter_keys' => 'kr std', 'col1_text' => 'بایوتم (Biotem)', 'col2_type' => 'country', 'col2_country' => '🇰🇷 کره‌ای', 'col3_type' => 'pill_std', 'col3_text' => 'استاندارد', 'col4_type' => 'price', 'col4_text' => '۳۲٬۰۰۰٬۰۰۰ تومان' ],
					[ 'row_filter_keys' => 'kr eco', 'col1_text' => 'دنتیس وان کیو (DENTIS One Q)', 'col2_type' => 'country', 'col2_country' => '🇰🇷 کره‌ای', 'col3_type' => 'pill_eco', 'col3_text' => 'اقتصادی', 'col4_type' => 'price', 'col4_text' => '۳۰٬۰۰۰٬۰۰۰ تومان' ],
					[ 'row_filter_keys' => 'kr eco', 'col1_text' => 'آستم (Osstem)', 'col2_type' => 'country', 'col2_country' => '🇰🇷 کره‌ای', 'col3_type' => 'pill_eco', 'col3_text' => 'اقتصادی', 'col4_type' => 'price', 'col4_text' => '۳۱٬۵۰۰٬۰۰۰ تومان' ],
					[ 'row_filter_keys' => 'kr eco', 'col1_text' => 'ایمپلنتیوم (Implantium)', 'col2_type' => 'country', 'col2_country' => '🇰🇷 کره‌ای', 'col3_type' => 'pill_eco', 'col3_text' => 'اقتصادی', 'col4_type' => 'price', 'col4_text' => '۳۰٬۰۰۰٬۰۰۰ تومان' ],
					[ 'row_filter_keys' => 'de eco', 'col1_text' => 'آی‌سی‌ایکس (ICX)', 'col2_type' => 'country', 'col2_country' => '🇩🇪 آلمانی', 'col3_type' => 'pill_eco', 'col3_text' => 'اقتصادی', 'col4_type' => 'price', 'col4_text' => '۳۱٬۰۰۰٬۰۰۰ تومان' ],
					[ 'row_filter_keys' => 'de pre', 'col1_text' => 'بگو (Bego)', 'col2_type' => 'country', 'col2_country' => '🇩🇪 آلمانی', 'col3_type' => 'pill_pre', 'col3_text' => 'پریمیوم', 'col4_type' => 'price', 'col4_text' => '۵۳٬۰۰۰٬۰۰۰ تومان' ],
					[ 'row_filter_keys' => 'ch std', 'col1_text' => 'اس‌آی‌سی (SIC)', 'col2_type' => 'country', 'col2_country' => '🇨🇭 سوئیسی', 'col3_type' => 'pill_std', 'col3_text' => 'استاندارد', 'col4_type' => 'price', 'col4_text' => '۳۸٬۰۰۰٬۰۰۰ تومان' ],
					[ 'row_filter_keys' => 'ch std', 'col1_text' => 'نئودنت (Neodent)', 'col2_type' => 'country', 'col2_country' => '🇨🇭 گروه اشترومن (تولید برزیل)', 'col3_type' => 'pill_std', 'col3_text' => 'استاندارد', 'col4_type' => 'price', 'col4_text' => '۳۸٬۰۰۰٬۰۰۰ تومان' ],
					[ 'row_filter_keys' => 'ch pre', 'col1_text' => 'اشترومن / نئودنت اکوا (Straumann)', 'col2_type' => 'country', 'col2_country' => '🇨🇭 سوئیسی', 'col3_type' => 'pill_pre', 'col3_text' => 'پریمیوم', 'col4_type' => 'price', 'col4_text' => '۴۵٬۰۰۰٬۰۰۰ تومان' ],
					[ 'row_filter_keys' => 'ch pre', 'col1_text' => 'آی‌تی‌آی (ITI)', 'col2_type' => 'country', 'col2_country' => '🇨🇭 سوئیسی', 'col3_type' => 'pill_pre', 'col3_text' => 'پریمیوم', 'col4_type' => 'price', 'col4_text' => '۷۰٬۰۰۰٬۰۰۰ تومان' ],
					[ 'row_filter_keys' => 'us std', 'col1_text' => 'زیمر / بایوهورایزن (Zimmer, BioHorizons)', 'col2_type' => 'country', 'col2_country' => '🇺🇸 آمریکایی', 'col3_type' => 'pill_std', 'col3_text' => 'استاندارد', 'col4_type' => 'price', 'col4_text' => '۳۶ تا ۴۵ میلیون تومان' ],
				],
			],
			'crown_scenarios' => [
				'title'   => '۲. جدول قیمت ایمپلنت با روکش (۴ ستونه)',
				'cols'    => 4,
				'tabs'    => false,
				'headers' => [ 'سناریو', 'اجزای محاسبه', 'برآورد هزینه', 'مناسب برای' ],
				'caption' => '',
				'rows'    => [
					[ 'col1_text' => 'اقتصادی', 'col2_text' => 'پایه اقتصادی + روکش اقتصادی', 'col3_type' => 'price', 'col3_text' => '۴۴٬۰۰۰٬۰۰۰ تا ۴۵٬۵۰۰٬۰۰۰ تومان', 'col4_text' => 'بیمارانی که کنترل بودجه اولویت اولشان است' ],
					[ 'row_highlight' => 'yes', 'col1_text' => 'استاندارد ⭐', 'col2_text' => 'پایه میان‌رده + روکش رایج', 'col3_type' => 'price', 'col3_text' => '۵۷٬۰۰۰٬۰۰۰ تا ۶۹٬۰۰۰٬۰۰۰ تومان', 'col4_text' => 'انتخاب متعادل برای بیشتر درمان‌های معمول' ],
					[ 'col1_text' => 'پریمیوم', 'col2_text' => 'پایه پریمیوم + روکش پریمیوم', 'col3_type' => 'price', 'col3_text' => '۸۳٬۰۰۰٬۰۰۰ تا ۱۰۸٬۰۰۰٬۰۰۰ تومان', 'col4_text' => 'دندان‌های جلو و درمان‌های حساس از نظر زیبایی' ],
				],
			],
			'crown_types' => [
				'title'   => '۳. جدول قیمت انواع روکش ایمپلنت (۳ ستونه)',
				'cols'    => 3,
				'tabs'    => false,
				'headers' => [ 'نوع روکش', 'ویژگی', 'قیمت هر واحد' ],
				'caption' => 'بازه کلی هزینه روکش به‌تنهایی: ۱۴ تا ۳۸ میلیون تومان.',
				'rows'    => [
					[ 'col1_text' => 'PFM (متال‌سرامیک)', 'col2_text' => 'مقاوم و اقتصادی؛ مناسب دندان‌های عقب', 'col3_type' => 'price', 'col3_text' => '۱۴٬۰۰۰٬۰۰۰ تومان' ],
					[ 'row_highlight' => 'yes', 'col1_text' => 'زیرکونیا', 'col2_text' => 'تعادل استحکام و زیبایی؛ بدون فلز', 'col3_type' => 'price', 'col3_text' => '۲۰٬۵۰۰٬۰۰۰ تومان' ],
					[ 'col1_text' => 'ایمکس (EMAX)', 'col2_text' => 'بیشترین شفافیت و طبیعی‌بودن؛ مناسب ناحیه جلو', 'col3_type' => 'price', 'col3_text' => '۳۵٬۰۰۰٬۰۰۰ تومان' ],
				],
			],
			'countries' => [
				'title'   => '۴. جدول قیمت بر اساس کشور سازنده (۴ ستونه)',
				'cols'    => 4,
				'tabs'    => false,
				'headers' => [ 'کشور / دسته', 'بازه قیمت پایه', 'برندهای نمونه', 'مناسب برای' ],
				'caption' => '',
				'rows'    => [
					[ 'col1_type' => 'country', 'col1_country' => '🇰🇷 ایمپلنت کره‌ای', 'col2_type' => 'price', 'col2_text' => '۳۰٬۰۰۰٬۰۰۰ تا ۳۲٬۵۰۰٬۰۰۰ تومان', 'col3_text' => 'مگاژن، بایوتم، آستم، دنتیس، ایمپلنتیوم', 'col4_text' => 'کسانی که گزینه اقتصادی و پرکاربرد می‌خواهند' ],
					[ 'col1_type' => 'country', 'col1_country' => '🇩🇪 ایمپلنت آلمانی', 'col2_type' => 'price', 'col2_text' => '۳۰٬۰۰۰٬۰۰۰ تا ۵۳٬۰۰۰٬۰۰۰ تومان', 'col3_text' => 'بگو، آلفادنت، ICX', 'col4_text' => 'کسانی که تعادل کیفیت و قیمت می‌خواهند' ],
					[ 'col1_type' => 'country', 'col1_country' => '🇨🇭 ایمپلنت سوئیسی', 'col2_type' => 'price', 'col2_text' => '۳۱٬۰۰۰٬۰۰۰ تا ۷۰٬۰۰۰٬۰۰۰ تومان', 'col3_text' => 'اشترومن، SIC، نئودنت، ITI', 'col4_text' => 'کسانی که دنبال انتخاب پریمیوم هستند' ],
					[ 'col1_type' => 'country', 'col1_country' => '🇺🇸 ایمپلنت آمریکایی', 'col2_type' => 'price', 'col2_text' => '۳۶٬۰۰۰٬۰۰۰ تا ۴۵٬۰۰۰٬۰۰۰ تومان', 'col3_text' => 'زیمر، بایوهورایزن', 'col4_text' => 'کسانی که برندهای بین‌المللی خاص را بررسی می‌کنند' ],
				],
			],
			'common_scenarios' => [
				'title'   => '۵. جدول سناریوهای رایج هزینه ایمپلنت (۴ ستونه)',
				'cols'    => 4,
				'tabs'    => false,
				'headers' => [ 'سناریو', 'شامل چه مواردی است؟', 'برآورد هزینه', 'یادداشت' ],
				'caption' => '',
				'rows'    => [
					[ 'row_highlight' => 'yes', 'col1_text' => 'یک واحد ایمپلنت ساده با روکش', 'col2_text' => 'پایه + روکش', 'col3_type' => 'price', 'col3_text' => '۴۴٬۰۰۰٬۰۰۰ تا ۱۰۸٬۰۰۰٬۰۰۰ تومان', 'col4_text' => 'بدون خدمات جانبی' ],
					[ 'col1_text' => 'ایمپلنت با کشیدن دندان', 'col2_text' => 'پایه + روکش + کشیدن دندان', 'col3_type' => 'price', 'col3_text' => '۵۸٬۰۰۰٬۰۰۰ تا ۱۲۲٬۰۰۰٬۰۰۰ تومان', 'col4_text' => 'اگر دندان یا ریشه باقی مانده باشد' ],
					[ 'col1_text' => 'ایمپلنت با پیوند استخوان', 'col2_text' => 'پایه + روکش + پیوند استخوان', 'col3_type' => 'price', 'col3_text' => '۵۵٬۰۰۰٬۰۰۰ تا ۱۱۹٬۰۰۰٬۰۰۰ تومان', 'col4_text' => 'در صورت تحلیل یا کمبود استخوان' ],
					[ 'col1_text' => 'ایمپلنت فک بالا با سینوس لیفت', 'col2_text' => 'پایه + روکش + سینوس لیفت', 'col3_type' => 'price', 'col3_text' => '۶۰٬۵۰۰٬۰۰۰ تا ۱۲۴٬۵۰۰٬۰۰۰ تومان', 'col4_text' => 'در بعضی کیس‌های فک بالا' ],
				],
			],
			'extras' => [
				'title'   => '۶. جدول هزینه خدمات جانبی ایمپلنت (۴ ستونه)',
				'cols'    => 4,
				'tabs'    => false,
				'headers' => [ 'خدمت جانبی', 'قیمت', 'چه زمانی لازم می‌شود؟', 'اثر روی برآورد' ],
				'caption' => '',
				'rows'    => [
					[ 'col1_text' => 'جراحی ساده دندان عقل', 'col2_type' => 'price', 'col2_text' => '۱۲٬۰۰۰٬۰۰۰ تومان', 'col3_text' => 'اگر دندان یا ریشه باقی مانده باشد', 'col4_text' => 'فقط در صورت نیاز' ],
					[ 'col1_text' => 'دندان عقل نیمه‌نهفته', 'col2_type' => 'price', 'col2_text' => '۱۵٬۰۰۰٬۰۰۰ تومان', 'col3_text' => 'اگر دندان یا ریشه باقی مانده باشد', 'col4_text' => 'فقط در صورت نیاز' ],
					[ 'col1_text' => 'دندان عقل نهفته', 'col2_type' => 'price', 'col2_text' => '۲۰٬۰۰۰٬۰۰۰ تومان', 'col3_text' => 'اگر دندان یا ریشه باقی مانده باشد', 'col4_text' => 'فقط در صورت نیاز' ],
					[ 'col1_text' => 'جراحی دندان عقل روی عصب', 'col2_type' => 'price', 'col2_text' => '۲۵٬۰۰۰٬۰۰۰ تومان', 'col3_text' => 'بسته به تشخیص پزشک', 'col4_text' => 'فقط در صورت نیاز' ],
					[ 'col1_text' => 'اوردنچر یک فک', 'col2_type' => 'price', 'col2_text' => '۲۵۰٬۰۰۰٬۰۰۰ تومان', 'col3_text' => 'بسته به تشخیص پزشک', 'col4_text' => 'فقط در صورت نیاز' ],
					[ 'col1_text' => 'لیفت لثه', 'col2_type' => 'price', 'col2_text' => '۸٬۰۰۰٬۰۰۰ تومان', 'col3_text' => 'بسته به تشخیص پزشک', 'col4_text' => 'فقط در صورت نیاز' ],
					[ 'col1_text' => 'سینوس لیفت بسته (Close)', 'col2_type' => 'price', 'col2_text' => '۱۵٬۰۰۰٬۰۰۰ تومان', 'col3_text' => 'در بعضی کیس‌های فک بالا', 'col4_text' => 'فقط در صورت نیاز' ],
					[ 'col1_text' => 'سینوس لیفت باز (Open)', 'col2_type' => 'price', 'col2_text' => '۲۰٬۰۰۰٬۰۰۰ تومان', 'col3_text' => 'در بعضی کیس‌های فک بالا', 'col4_text' => 'فقط در صورت نیاز' ],
					[ 'col1_text' => 'پیوند استخوان موضعی', 'col2_type' => 'price', 'col2_text' => '۱۰٬۰۰۰٬۰۰۰ تومان', 'col3_text' => 'تحلیل یا کمبود استخوان فک', 'col4_text' => 'فقط در صورت نیاز' ],
					[ 'col1_text' => 'پیوند ریج استخوانی', 'col2_type' => 'price', 'col2_text' => '۲۰٬۰۰۰٬۰۰۰ تومان', 'col3_text' => 'تحلیل یا کمبود استخوان فک', 'col4_text' => 'فقط در صورت نیاز' ],
					[ 'col1_text' => 'پودر استخوان', 'col2_type' => 'price', 'col2_text' => '۱۵٬۰۰۰٬۰۰۰ تومان', 'col3_text' => 'بازسازی یا تقویت حجم استخوان', 'col4_text' => 'فقط در صورت نیاز' ],
					[ 'col1_text' => 'CBCT / اسکن دیجیتال', 'col2_type' => 'price', 'col2_text' => 'طبق تعرفه کلینیک', 'col3_text' => 'طراحی دقیق درمان دیجیتال', 'col4_text' => 'بسته به پلن درمان' ],
				],
			],
			'included' => [
				'title'   => '۷. جدول قیمت شامل چه مواردی می‌شود؟ (۳ ستونه + بج)',
				'cols'    => 3,
				'tabs'    => false,
				'headers' => [ 'مورد', 'وضعیت در محاسبه', 'توضیح' ],
				'caption' => '',
				'rows'    => [
					[ 'col1_text' => 'پایه ایمپلنت', 'col2_type' => 'pill_eco', 'col2_text' => '✓ در قیمت پایه', 'col3_text' => 'قطعه‌ای که داخل استخوان فک قرار می‌گیرد.' ],
					[ 'col1_text' => 'روکش ایمپلنت', 'col2_type' => 'pill_pre', 'col2_text' => 'جداگانه', 'col3_text' => 'جنس روکش روی برآورد اثر دارد.' ],
					[ 'col1_text' => 'کشیدن دندان', 'col2_type' => 'pill_pre', 'col2_text' => 'فقط در صورت نیاز', 'col3_text' => 'اگر دندان یا ریشه باقی مانده باشد.' ],
					[ 'col1_text' => 'پیوند یا پودر استخوان', 'col2_type' => 'pill_pre', 'col2_text' => 'فقط در صورت نیاز', 'col3_text' => 'در صورت کمبود یا تحلیل استخوان.' ],
					[ 'col1_text' => 'سینوس لیفت', 'col2_type' => 'pill_pre', 'col2_text' => 'فقط در بعضی کیس‌ها', 'col3_text' => 'بیشتر در درمان‌های فک بالا.' ],
					[ 'col1_text' => 'CBCT / عکس / اسکن', 'col2_type' => 'pill_std', 'col2_text' => 'بسته به پلن درمان', 'col3_text' => 'برای بررسی دقیق استخوان و طراحی دیجیتال درمان.' ],
				],
			],
			'full_arch' => [
				'title'   => '۸. جدول ایمپلنت چند واحدی و کامل فک (۴ ستونه)',
				'cols'    => 4,
				'tabs'    => false,
				'headers' => [ 'نوع درمان', 'بازه قیمت تقریبی', 'نحوه محاسبه', 'توضیح' ],
				'caption' => '',
				'rows'    => [
					[ 'col1_text' => 'ایمپلنت چند دندان', 'col2_type' => 'price', 'col2_text' => 'متناسب با تعداد', 'col3_text' => 'تعداد پایه × قیمت پایه منتخب + تعداد روکش', 'col4_text' => 'چند دندان از دست‌رفته در یک یا چند ناحیه' ],
					[ 'col1_text' => 'ایمپلنت کامل فک بالا', 'col2_type' => 'price', 'col2_text' => '۱۲۰ تا ۳۵۰ میلیون تومان', 'col3_text' => 'تعداد پایه + نوع پروتز + برند + وضعیت استخوان', 'col4_text' => 'ممکن است سینوس لیفت یا پیوند لازم شود' ],
					[ 'col1_text' => 'ایمپلنت کامل فک پایین', 'col2_type' => 'price', 'col2_text' => '۱۲۰ تا ۳۵۰ میلیون تومان', 'col3_text' => 'تعداد پایه + نوع پروتز + برند + وضعیت استخوان', 'col4_text' => 'پلن درمان بعد از معاینه مشخص می‌شود' ],
					[ 'row_highlight' => 'yes', 'col1_text' => 'فول ماوث (دو فک)', 'col2_type' => 'price', 'col2_text' => '۲۴۰ تا ۷۰۰ میلیون تومان', 'col3_text' => 'پلن اختصاصی برای هر دو فک', 'col4_text' => 'بررسی عکس و طرح درمان ضروری است' ],
				],
			],
			'insurance' => [
				'title'   => '۹. جدول پوشش بیمه برای ایمپلنت (۴ ستونه + ۲ ستون بج)',
				'cols'    => 4,
				'tabs'    => false,
				'headers' => [ 'نوع بیمه یا طرح', 'پوشش ایمپلنت', 'پوشش دندانپزشکی', 'توضیح' ],
				'caption' => '',
				'rows'    => [
					[ 'col1_text' => 'تأمین اجتماعی', 'col2_type' => 'pill_no', 'col2_text' => 'خیر', 'col3_type' => 'pill_pre', 'col3_text' => 'محدود', 'col4_text' => 'خدمات پایه مثل کشیدن و جرم‌گیری؛ ایمپلنت معمولاً جزو تعهدات نیست.' ],
					[ 'col1_text' => 'بیمه سلامت', 'col2_type' => 'pill_no', 'col2_text' => 'خیر', 'col3_type' => 'pill_pre', 'col3_text' => 'محدود', 'col4_text' => 'بیشتر برای خدمات پایه؛ درمان‌های تخصصی معمولاً پوشش مؤثر ندارند.' ],
					[ 'col1_text' => 'نیروهای مسلح', 'col2_type' => 'pill_pre', 'col2_text' => 'مشروط', 'col3_type' => 'pill_pre', 'col3_text' => 'مشروط', 'col4_text' => 'باید جدول تعهدات همان بیمه‌نامه بررسی شود.' ],
					[ 'col1_text' => 'تکمیلی انفرادی', 'col2_type' => 'pill_no', 'col2_text' => 'خیر', 'col3_type' => 'pill_eco', 'col3_text' => 'بله', 'col4_text' => 'خدمات عمومی تا سقف مشخص؛ ایمپلنت معمولاً جزو تعهدات اصلی نیست.' ],
					[ 'row_highlight' => 'yes', 'col1_text' => 'تکمیلی گروهی / سازمانی', 'col2_type' => 'pill_pre', 'col2_text' => 'مشروط', 'col3_type' => 'pill_eco', 'col3_text' => 'بله', 'col4_text' => 'بیشترین احتمال پوشش؛ به شرط درج ایمپلنت در جدول تعهدات.' ],
					[ 'col1_text' => 'بیمه ایران', 'col2_type' => 'pill_pre', 'col2_text' => 'مشروط', 'col3_type' => 'pill_eco', 'col3_text' => 'بله', 'col4_text' => 'وابسته به نوع قرارداد و سقف تعهدات.' ],
					[ 'col1_text' => 'بیمه دانا', 'col2_type' => 'pill_pre', 'col2_text' => 'مشروط', 'col3_type' => 'pill_eco', 'col3_text' => 'بله', 'col4_text' => 'در طرح‌های گروهی، فقط در صورت درج در قرارداد.' ],
					[ 'col1_text' => 'بیمه آسیا', 'col2_type' => 'pill_pre', 'col2_text' => 'مشروط', 'col3_type' => 'pill_eco', 'col3_text' => 'بله', 'col4_text' => 'جدول تعهدات همان طرح باید بررسی شود.' ],
					[ 'col1_text' => 'بیمه البرز', 'col2_type' => 'pill_pre', 'col2_text' => 'مشروط', 'col3_type' => 'pill_eco', 'col3_text' => 'بله', 'col4_text' => 'پوشش عمومی برای همه بیمه‌نامه‌ها قابل اعلام نیست.' ],
					[ 'col1_text' => 'بیمه سامان', 'col2_type' => 'pill_pre', 'col2_text' => 'مشروط', 'col3_type' => 'pill_eco', 'col3_text' => 'بله', 'col4_text' => 'در انفرادی محدود؛ در گروهی بسته به سقف تعهدات.' ],
					[ 'col1_text' => 'بیمه پاسارگاد', 'col2_type' => 'pill_pre', 'col2_text' => 'مشروط', 'col3_type' => 'pill_eco', 'col3_text' => 'بله', 'col4_text' => 'با قرارداد گروهی و درج ایمپلنت قابل پیگیری است.' ],
					[ 'col1_text' => 'بیمه ملت', 'col2_type' => 'pill_pre', 'col2_text' => 'مشروط', 'col3_type' => 'pill_eco', 'col3_text' => 'بله', 'col4_text' => 'فقط در صورت تعهد مشخص در قرارداد.' ],
					[ 'col1_text' => 'بیمه دی', 'col2_type' => 'pill_pre', 'col2_text' => 'مشروط', 'col3_type' => 'pill_eco', 'col3_text' => 'بله', 'col4_text' => 'در انفرادی پوشش قطعی ندارد؛ در گروهی ممکن است باشد.' ],
					[ 'col1_text' => 'آتیه‌سازان حافظ', 'col2_type' => 'pill_no', 'col2_text' => 'خیر', 'col3_type' => 'pill_pre', 'col3_text' => 'محدود', 'col4_text' => 'ایمپلنت معمولاً خارج از تعهد است مگر با قرارداد خاص.' ],
					[ 'col1_text' => 'SOS / کمک‌رسان ایران', 'col2_type' => 'pill_pre', 'col2_text' => 'مشروط', 'col3_type' => 'pill_pre', 'col3_text' => 'مشروط', 'col4_text' => 'بعضی طرح‌ها ایمپلنت را خارج از تعهد اعلام می‌کنند.' ],
					[ 'col1_text' => 'بنیان کارت / بنیان سلامت', 'col2_type' => 'pill_no', 'col2_text' => 'خیر', 'col3_type' => 'pill_pre', 'col3_text' => 'محدود', 'col4_text' => 'کارت تخفیف است نه بیمه تکمیلی؛ فقط در مراکز طرف قرارداد.' ],
				],
			],
			'factors' => [
				'title'   => '۱۰. جدول عوامل مؤثر بر تفاوت قیمت (۳ ستونه)',
				'cols'    => 3,
				'tabs'    => false,
				'headers' => [ 'عامل مؤثر', 'اثر روی قیمت', 'مثال' ],
				'caption' => '',
				'rows'    => [
					[ 'col1_text' => 'برند پایه ایمپلنت', 'col2_text' => 'برندها قیمت و سطح کیفی متفاوت دارند.', 'col3_text' => 'کره‌ای، آلمانی، سوئیسی' ],
					[ 'col1_text' => 'نوع روکش', 'col2_text' => 'جنس و کیفیت روکش برآورد را تغییر می‌دهد.', 'col3_text' => 'PFM، زیرکونیا، ایمکس' ],
					[ 'col1_text' => 'تعداد دندان‌های از دست‌رفته', 'col2_text' => 'پایه و روکش بیشتر یعنی هزینه بیشتر.', 'col3_text' => 'یک واحد، چند واحد، فک کامل' ],
					[ 'col1_text' => 'وضعیت استخوان فک', 'col2_text' => 'کمبود استخوان درمان جانبی لازم می‌کند.', 'col3_text' => 'پیوند یا پودر استخوان' ],
					[ 'col1_text' => 'موقعیت دندان', 'col2_text' => 'بعضی نواحی از نظر زیبایی یا دسترسی حساس‌ترند.', 'col3_text' => 'دندان جلو یا فک بالا' ],
					[ 'col1_text' => 'سینوس لیفت', 'col2_text' => 'در بعضی کیس‌های فک بالا هزینه جداگانه دارد.', 'col3_text' => 'درمان‌های نزدیک سینوس' ],
					[ 'row_highlight' => 'yes', 'col1_text' => 'پلن دیجیتال یا معمولی', 'col2_text' => 'اسکن و طراحی دیجیتال دقت درمان را بالا می‌برد و روی فرایند و هزینه اثر دارد.', 'col3_text' => 'CBCT، اسکن داخل دهانی، گاید جراحی' ],
				],
			],
		];
	}

	/**
	 * ساخت فیلدهای Repeater شامل دراپ‌داون کشورها برای هر ستون
	 */
	private function get_row_repeater_controls( $has_tabs = false ) {
		$repeater = new Repeater();

		if ( $has_tabs ) {
			$repeater->add_control(
				'row_filter_keys',
				[
					'label'       => 'کلیدهای فیلتر تب (با فاصله جدا کنید)',
					'type'        => Controls_Manager::TEXT,
					'default'     => 'kr std',
					'description' => 'مثال: kr std یا de pre',
				]
			);
		}

		$repeater->add_control(
			'row_highlight',
			[
				'label'        => 'هایلایت کردن این ردیف (رنگ ویژه)؟',
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => 'بله',
				'label_off'    => 'خیر',
				'return_value' => 'yes',
				'default'      => '',
			]
		);

		$cell_type_options = [
			'text'     => 'متن عادی',
			'country'  => '🏳️ لیست کشویی کشورها (با پرچم)',
			'price'    => '💰 قیمت (بولد و رنگی)',
			'pill_std' => '🔵 برچسب کپسولی: استاندارد (آبی)',
			'pill_eco' => '🟢 برچسب کپسولی: اقتصادی / بله (سبز)',
			'pill_pre' => '🟡 برچسب کپسولی: پریمیوم / مشروط (زرد)',
			'pill_no'  => '🔴 برچسب کپسولی: عدم پوشش / خیر (قرمز)',
		];

		$countries = $this->get_countries_list();

		for ( $c = 1; $c <= 5; $c++ ) {
			$repeater->add_control(
				"col{$c}_heading",
				[
					'label'     => "ستون {$c}",
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);

			$repeater->add_control(
				"col{$c}_type",
				[
					'label'   => "نوع محتوای ستون {$c}",
					'type'    => Controls_Manager::SELECT,
					'default' => 'text',
					'options' => $cell_type_options,
				]
			);

			$repeater->add_control(
				"col{$c}_country",
				[
					'label'     => "انتخاب کشور (ستون {$c})",
					'type'      => Controls_Manager::SELECT,
					'default'   => '🇰🇷 کره‌ای',
					'options'   => $countries,
					'condition' => [ "col{$c}_type" => 'country' ],
				]
			);

			$repeater->add_control(
				"col{$c}_text",
				[
					'label'      => "متن ستون {$c}",
					'type'       => Controls_Manager::TEXT,
					'default'    => '',
					'conditions' => [
						'relation' => 'or',
						'terms'    => [
							[
								'name'     => "col{$c}_type",
								'operator' => '!==',
								'value'    => 'country',
							],
							[
								'relation' => 'and',
								'terms'    => [
									[
										'name'     => "col{$c}_type",
										'operator' => '===',
										'value'    => 'country',
									],
									[
										'name'     => "col{$c}_country",
										'operator' => '===',
										'value'    => 'custom',
									],
								],
							],
						],
					],
				]
			);
		}

		return $repeater->get_controls();
	}

	protected function register_controls() {

		$presets = $this->get_presets_data();
		$preset_options = [];
		foreach ( $presets as $key => $data ) {
			$preset_options[ $key ] = $data['title'];
		}
		$preset_options['custom'] = '⚙️ جدول سفارشی (تنظیم دلخواه تعداد ستون‌ها)';

		/* ==========================================
		 * تب محتوا: ۱. انتخاب قالب آماده جدول (۱۰ طرح)
		 * ========================================== */
		$this->start_controls_section(
			'section_table_preset',
			[
				'label' => '۱. انتخاب طرح و قالب آماده جدول',
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'table_preset',
			[
				'label'       => 'قالب جدول را انتخاب کنید:',
				'type'        => Controls_Manager::SELECT,
				'default'     => 'brands',
				'label_block' => true,
				'options'     => $preset_options,
				'description' => 'با انتخاب هر کدام از ۱۰ جدول بالا، ستون‌ها، سرستون‌ها و تمام ردیف‌های همان جدول به‌صورت آماده بارگذاری می‌شوند و نیاز به کم و زیاد کردن دستی جدول ندارید.',
			]
		);

		$this->add_control(
			'sticky_first_col',
			[
				'label'        => 'چسبان بودن ستون اول در موبایل (Sticky)',
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => 'بله',
				'label_off'    => 'خیر',
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		// فقط برای حالت سفارشی (Custom) امکان تغییر تعداد ستون نمایش داده شود
		$this->add_control(
			'custom_columns_count',
			[
				'label'     => 'تعداد ستون‌های جدول سفارشی',
				'type'      => Controls_Manager::SELECT,
				'default'   => '4',
				'options'   => [
					'2' => '۲ ستونه',
					'3' => '۳ ستونه',
					'4' => '۴ ستونه',
					'5' => '۵ ستونه',
				],
				'condition' => [ 'table_preset' => 'custom' ],
			]
		);

		$this->add_control(
			'override_headers',
			[
				'label'        => 'تغییر دستی عناوین سرستون‌ها یا متن زیر جدول؟',
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => 'بله',
				'label_off'    => 'پیش‌فرض قالب',
				'return_value' => 'yes',
				'default'      => '',
			]
		);

		for ( $i = 1; $i <= 5; $i++ ) {
			$this->add_control(
				"custom_th_{$i}",
				[
					'label'       => "عنوان سرستون {$i}",
					'type'        => Controls_Manager::TEXT,
					'default'     => '',
					'placeholder' => 'در صورت خالی بودن، عنوان پیش‌فرض قالب نمایش داده می‌شود',
					'condition'   => [ 'override_headers' => 'yes' ],
				]
			);
		}

		$this->add_control(
			'custom_caption',
			[
				'label'       => 'متن توضیح زیر جدول (Caption)',
				'type'        => Controls_Manager::TEXTAREA,
				'rows'        => 2,
				'condition'   => [ 'override_headers' => 'yes' ],
				'placeholder' => 'توضیحات زیر جدول را وارد کنید',
			]
		);

		$this->end_controls_section();

		/* ==========================================
		 * تب محتوا: ۲. تب‌های فیلتر بالای جدول
		 * ========================================== */
		$this->start_controls_section(
			'section_filter_tabs',
			[
				'label' => '۲. تب‌های فیلتر بالای جدول',
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'tabs_mode',
			[
				'label'   => 'وضعیت نمایش تب‌های فیلتر',
				'type'    => Controls_Manager::SELECT,
				'default' => 'auto',
				'options' => [
					'auto' => 'خودکار بر اساس قالب جدول (فقط برای جدول برندها)',
					'yes'  => 'همیشه فعال',
					'no'   => 'همیشه غیرفعال',
				],
			]
		);

		$tabs_repeater = new Repeater();

		$tabs_repeater->add_control(
			'tab_title',
			[
				'label'   => 'عنوان تب',
				'type'    => Controls_Manager::TEXT,
				'default' => 'کره‌ای',
			]
		);

		$tabs_repeater->add_control(
			'tab_key',
			[
				'label'   => 'کلید فیلتر (انگلیسی)',
				'type'    => Controls_Manager::TEXT,
				'default' => 'kr',
			]
		);

		$this->add_control(
			'tabs_list',
			[
				'label'       => 'لیست تب‌های فیلتر',
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $tabs_repeater->get_controls(),
				'title_field' => '{{{ tab_title }}} ({{{ tab_key }}})',
				'condition'   => [ 'tabs_mode!' => 'no' ],
				'default'     => [
					[ 'tab_title' => 'همه', 'tab_key' => 'all' ],
					[ 'tab_title' => 'کره‌ای', 'tab_key' => 'kr' ],
					[ 'tab_title' => 'آلمانی', 'tab_key' => 'de' ],
					[ 'tab_title' => 'سوئیسی', 'tab_key' => 'ch' ],
					[ 'tab_title' => 'آمریکایی', 'tab_key' => 'us' ],
					[ 'tab_title' => 'اقتصادی', 'tab_key' => 'eco' ],
					[ 'tab_title' => 'پریمیوم', 'tab_key' => 'pre' ],
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================
		 * تب محتوا: ۳. ردیف‌های اختصاصی هر قالب (Repeater)
		 * ========================================== */
		$this->start_controls_section(
			'section_table_rows',
			[
				'label' => '۳. ویرایش ردیف‌ها و قیمت‌های جدول انتخابی',
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		// ایجاد Repeater مجزا با مقادیر پیش‌فرض آماده برای هر یک از ۱۰ قالب جدول
		foreach ( $presets as $preset_key => $preset_data ) {
			$this->add_control(
				'rows_' . $preset_key,
				[
					'label'       => 'ردیف‌های ' . $preset_data['title'],
					'type'        => Controls_Manager::REPEATER,
					'fields'      => $this->get_row_repeater_controls( $preset_data['tabs'] ),
					'title_field' => '{{{ col1_type === "country" ? col1_country : col1_text }}}',
					'default'     => $preset_data['rows'],
					'condition'   => [ 'table_preset' => $preset_key ],
				]
			);
		}

		// Repeater برای حالت جدول سفارشی (Custom)
		$this->add_control(
			'rows_custom',
			[
				'label'       => 'ردیف‌های جدول سفارشی',
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $this->get_row_repeater_controls( true ),
				'title_field' => '{{{ col1_type === "country" ? col1_country : col1_text }}}',
				'default'     => $presets['brands']['rows'],
				'condition'   => [ 'table_preset' => 'custom' ],
			]
		);

		$this->end_controls_section();

		/* ==========================================
		 * تب استایل: ۱. استایل تب‌های فیلتر
		 * ========================================== */
		$this->start_controls_section(
			'section_style_tabs',
			[
				'label' => 'استایل تب‌های فیلتر',
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'tabs_alignment',
			[
				'label'     => 'چینش تب‌ها',
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'flex-start' => [ 'title' => 'راست', 'icon' => 'eicon-text-align-right' ],
					'center'     => [ 'title' => 'وسط', 'icon' => 'eicon-text-align-center' ],
					'flex-end'   => [ 'title' => 'چپ', 'icon' => 'eicon-text-align-left' ],
				],
				'default'   => 'flex-start',
				'selectors' => [ '{{WRAPPER}} .mwp-tabs' => 'justify-content: {{VALUE}};' ],
			]
		);

		$this->add_responsive_control(
			'tabs_gap',
			[
				'label'      => 'فاصله بین تب‌ها (Gap)',
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 30 ] ],
				'default'    => [ 'size' => 8, 'unit' => 'px' ],
				'selectors'  => [ '{{WRAPPER}} .mwp-tabs' => 'gap: {{SIZE}}{{UNIT}};' ],
			]
		);

		$this->add_responsive_control(
			'tabs_margin_bottom',
			[
				'label'      => 'فاصله پایین تب‌ها تا جدول',
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 50 ] ],
				'default'    => [ 'size' => 16, 'unit' => 'px' ],
				'selectors'  => [ '{{WRAPPER}} .mwp-tabs' => 'margin-bottom: {{SIZE}}{{UNIT}};' ],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'tabs_typography',
				'label'    => 'تایپوگرافی تب‌ها',
				'selector' => '{{WRAPPER}} .mwp-tab',
			]
		);

		$this->add_responsive_control(
			'tab_padding',
			[
				'label'      => 'فاصله داخلی هر تب (Padding)',
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .mwp-tab' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'tab_border_radius',
			[
				'label'      => 'شعاع قوس تب‌ها (Border Radius)',
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 100 ] ],
				'default'    => [ 'size' => 99, 'unit' => 'px' ],
				'selectors'  => [ '{{WRAPPER}} .mwp-tab' => 'border-radius: {{SIZE}}{{UNIT}};' ],
			]
		);

		$this->start_controls_tabs( 'tabs_color_states' );

		$this->start_controls_tab( 'tab_state_normal', [ 'label' => 'عادی' ] );
		$this->add_control(
			'tab_text_color',
			[
				'label'     => 'رنگ متن',
				'type'      => Controls_Manager::COLOR,
				'default'   => '#4A5878',
				'selectors' => [ '{{WRAPPER}} .mwp-tab' => 'color: {{VALUE}};' ],
			]
		);
		$this->add_control(
			'tab_bg_color',
			[
				'label'     => 'رنگ پس‌زمینه',
				'type'      => Controls_Manager::COLOR,
				'default'   => '#FFFFFF',
				'selectors' => [ '{{WRAPPER}} .mwp-tab' => 'background-color: {{VALUE}};' ],
			]
		);
		$this->add_control(
			'tab_border_color',
			[
				'label'     => 'رنگ کادر (Border)',
				'type'      => Controls_Manager::COLOR,
				'default'   => '#DCE6F7',
				'selectors' => [ '{{WRAPPER}} .mwp-tab' => 'border-color: {{VALUE}};' ],
			]
		);
		$this->end_controls_tab();

		$this->start_controls_tab( 'tab_state_hover', [ 'label' => 'هاور' ] );
		$this->add_control(
			'tab_hover_text_color',
			[
				'label'     => 'رنگ متن هاور',
				'type'      => Controls_Manager::COLOR,
				'default'   => '#1E5FD8',
				'selectors' => [ '{{WRAPPER}} .mwp-tab:hover' => 'color: {{VALUE}};' ],
			]
		);
		$this->add_control(
			'tab_hover_bg_color',
			[
				'label'     => 'رنگ پس‌زمینه هاور',
				'type'      => Controls_Manager::COLOR,
				'default'   => '#FFFFFF',
				'selectors' => [ '{{WRAPPER}} .mwp-tab:hover' => 'background-color: {{VALUE}};' ],
			]
		);
		$this->add_control(
			'tab_hover_border_color',
			[
				'label'     => 'رنگ کادر هاور',
				'type'      => Controls_Manager::COLOR,
				'default'   => '#1E5FD8',
				'selectors' => [ '{{WRAPPER}} .mwp-tab:hover' => 'border-color: {{VALUE}};' ],
			]
		);
		$this->end_controls_tab();

		$this->start_controls_tab( 'tab_state_active', [ 'label' => 'تب فعال' ] );
		$this->add_control(
			'tab_active_text_color',
			[
				'label'     => 'رنگ متن تب فعال',
				'type'      => Controls_Manager::COLOR,
				'default'   => '#FFFFFF',
				'selectors' => [ '{{WRAPPER}} .mwp-tab[aria-selected="true"]' => 'color: {{VALUE}};' ],
			]
		);
		$this->add_control(
			'tab_active_bg_color',
			[
				'label'     => 'رنگ پس‌زمینه تب فعال',
				'type'      => Controls_Manager::COLOR,
				'default'   => '#1E5FD8',
				'selectors' => [ '{{WRAPPER}} .mwp-tab[aria-selected="true"]' => 'background-color: {{VALUE}};' ],
			]
		);
		$this->add_control(
			'tab_active_border_color',
			[
				'label'     => 'رنگ کادر تب فعال',
				'type'      => Controls_Manager::COLOR,
				'default'   => '#1E5FD8',
				'selectors' => [ '{{WRAPPER}} .mwp-tab[aria-selected="true"]' => 'border-color: {{VALUE}};' ],
			]
		);
		$this->end_controls_tab();

		$this->end_controls_tabs();
		$this->end_controls_section();

		/* ==========================================
		 * تب استایل: ۲. استایل کادر کلی و هدر جدول
		 * ========================================== */
		$this->start_controls_section(
			'section_style_box_header',
			[
				'label' => 'کادر جدول و ردیف سرستون (Header)',
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'table_box_radius',
			[
				'label'      => 'گردی گوشه‌های کل جدول (Border Radius)',
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 40 ] ],
				'default'    => [ 'size' => 18, 'unit' => 'px' ],
				'selectors'  => [ '{{WRAPPER}} .mwp-tbl-container' => 'border-radius: {{SIZE}}{{UNIT}};' ],
			]
		);

		$this->add_control(
			'table_border_color',
			[
				'label'     => 'رنگ خطوط و کادر جدول',
				'type'      => Controls_Manager::COLOR,
				'default'   => '#DCE6F7',
				'selectors' => [
					'{{WRAPPER}} .mwp-tbl-container'  => 'border-color: {{VALUE}};',
					'{{WRAPPER}} .mwp-table thead th' => 'border-bottom-color: {{VALUE}};',
					'{{WRAPPER}} .mwp-table tbody td' => 'border-top-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'table_box_shadow',
				'label'    => 'سایه باکس جدول',
				'selector' => '{{WRAPPER}} .mwp-tbl-container',
			]
		);

		$this->add_control(
			'header_bg_color',
			[
				'label'     => 'رنگ پس‌زمینه هدر جدول',
				'type'      => Controls_Manager::COLOR,
				'default'   => '#EAF2FF',
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .mwp-table thead th'                     => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .mwp-table.is-sticky-col th:first-child' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'header_text_color',
			[
				'label'     => 'رنگ متن هدر جدول',
				'type'      => Controls_Manager::COLOR,
				'default'   => '#0E3A8A',
				'selectors' => [ '{{WRAPPER}} .mwp-table thead th' => 'color: {{VALUE}};' ],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'header_typography',
				'label'    => 'تایپوگرافی هدر جدول',
				'selector' => '{{WRAPPER}} .mwp-table thead th',
			]
		);

		$this->add_responsive_control(
			'header_padding',
			[
				'label'      => 'فاصله داخلی سلول‌های هدر',
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .mwp-table thead th' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================
		 * تب استایل: ۳. استایل ردیف‌ها و قیمت
		 * ========================================== */
		$this->start_controls_section(
			'section_style_rows',
			[
				'label' => 'استایل ردیف‌ها، سلول‌ها و قیمت',
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'body_typography',
				'label'    => 'تایپوگرافی متن سلول‌ها',
				'selector' => '{{WRAPPER}} .mwp-table tbody td',
			]
		);

		$this->add_responsive_control(
			'cell_padding',
			[
				'label'      => 'فاصله داخلی سلول‌های جدول',
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .mwp-table tbody td' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'row_bg_color',
			[
				'label'     => 'رنگ پس‌زمینه ردیف‌ها (عادی)',
				'type'      => Controls_Manager::COLOR,
				'default'   => '#FFFFFF',
				'selectors' => [ '{{WRAPPER}} .mwp-table tbody td' => 'background-color: {{VALUE}};' ],
			]
		);

		$this->add_control(
			'row_hover_bg_color',
			[
				'label'     => 'رنگ پس‌زمینه ردیف هنگام هاور',
				'type'      => Controls_Manager::COLOR,
				'default'   => '#F5F9FF',
				'selectors' => [ '{{WRAPPER}} .mwp-table tbody tr:hover td' => 'background-color: {{VALUE}};' ],
			]
		);

		$this->add_control(
			'row_hl_bg_color',
			[
				'label'     => 'رنگ پس‌زمینه ردیف‌های هایلایت شده (ویژه)',
				'type'      => Controls_Manager::COLOR,
				'default'   => '#FFF4D6',
				'selectors' => [ '{{WRAPPER}} .mwp-table tbody tr.mwp-row-hl td' => 'background-color: {{VALUE}} !important;' ],
			]
		);

		$this->add_control(
			'row_text_color',
			[
				'label'     => 'رنگ متن عادی سلول‌ها',
				'type'      => Controls_Manager::COLOR,
				'default'   => '#0B1B3F',
				'selectors' => [ '{{WRAPPER}} .mwp-table tbody td' => 'color: {{VALUE}};' ],
			]
		);

		$this->add_control(
			'price_text_color',
			[
				'label'     => 'رنگ متن قیمت‌ها',
				'type'      => Controls_Manager::COLOR,
				'default'   => '#0E3A8A',
				'selectors' => [ '{{WRAPPER}} .mwp-table tbody td.mwp-price-cell' => 'color: {{VALUE}};' ],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'price_typography',
				'label'    => 'تایپوگرافی ستون قیمت',
				'selector' => '{{WRAPPER}} .mwp-table tbody td.mwp-price-cell',
			]
		);

		$this->end_controls_section();

		/* ==========================================
		 * تب استایل: ۴. استایل برچسب‌های کپسولی (Pills)
		 * ========================================== */
		$this->start_controls_section(
			'section_style_pills',
			[
				'label' => 'استایل برچسب‌های کپسولی (Pills)',
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'pill_typography',
				'label'    => 'تایپوگرافی برچسب‌ها',
				'selector' => '{{WRAPPER}} .mwp-pill',
			]
		);

		$this->add_control(
			'pill_std_bg',
			[
				'label'     => 'پس‌زمینه برچسب استاندارد (آبی)',
				'type'      => Controls_Manager::COLOR,
				'default'   => '#EAF2FF',
				'separator' => 'before',
				'selectors' => [ '{{WRAPPER}} .mwp-pill.std' => 'background-color: {{VALUE}};' ],
			]
		);
		$this->add_control(
			'pill_std_color',
			[
				'label'     => 'رنگ متن برچسب استاندارد (آبی)',
				'type'      => Controls_Manager::COLOR,
				'default'   => '#0E3A8A',
				'selectors' => [ '{{WRAPPER}} .mwp-pill.std' => 'color: {{VALUE}};' ],
			]
		);

		$this->add_control(
			'pill_eco_bg',
			[
				'label'     => 'پس‌زمینه برچسب اقتصادی / بله (سبز)',
				'type'      => Controls_Manager::COLOR,
				'default'   => '#E6F6EE',
				'separator' => 'before',
				'selectors' => [ '{{WRAPPER}} .mwp-pill.eco' => 'background-color: {{VALUE}};' ],
			]
		);
		$this->add_control(
			'pill_eco_color',
			[
				'label'     => 'رنگ متن برچسب اقتصادی / بله (سبز)',
				'type'      => Controls_Manager::COLOR,
				'default'   => '#0F9D58',
				'selectors' => [ '{{WRAPPER}} .mwp-pill.eco' => 'color: {{VALUE}};' ],
			]
		);

		$this->add_control(
			'pill_pre_bg',
			[
				'label'     => 'پس‌زمینه برچسب پریمیوم / مشروط (زرد)',
				'type'      => Controls_Manager::COLOR,
				'default'   => '#FFF4D6',
				'separator' => 'before',
				'selectors' => [ '{{WRAPPER}} .mwp-pill.pre' => 'background-color: {{VALUE}};' ],
			]
		);
		$this->add_control(
			'pill_pre_color',
			[
				'label'     => 'رنگ متن برچسب پریمیوم / مشروط (زرد)',
				'type'      => Controls_Manager::COLOR,
				'default'   => '#7A5300',
				'selectors' => [ '{{WRAPPER}} .mwp-pill.pre' => 'color: {{VALUE}};' ],
			]
		);

		$this->add_control(
			'pill_no_bg',
			[
				'label'     => 'پس‌زمینه برچسب عدم پوشش / خیر (قرمز)',
				'type'      => Controls_Manager::COLOR,
				'default'   => '#FDECEC',
				'separator' => 'before',
				'selectors' => [ '{{WRAPPER}} .mwp-pill.no' => 'background-color: {{VALUE}};' ],
			]
		);
		$this->add_control(
			'pill_no_color',
			[
				'label'     => 'رنگ متن برچسب عدم پوشش / خیر (قرمز)',
				'type'      => Controls_Manager::COLOR,
				'default'   => '#B42318',
				'selectors' => [ '{{WRAPPER}} .mwp-pill.no' => 'color: {{VALUE}};' ],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * رندر کردن هر سلول جدول (پشتیبانی از دراپ‌داون کشورها، قیمت، بج و متن)
	 */
	private function render_table_cell( $row, $col_index ) {
		$type    = isset( $row[ "col{$col_index}_type" ] ) ? $row[ "col{$col_index}_type" ] : 'text';
		$text    = isset( $row[ "col{$col_index}_text" ] ) ? $row[ "col{$col_index}_text" ] : '';
		$country = isset( $row[ "col{$col_index}_country" ] ) ? $row[ "col{$col_index}_country" ] : '';

		// اگر نوع سلول روی کشور بود، مقدار انتخابی از لیست کشویی را نمایش بده (مگر اینکه روی custom باشد)
		if ( $type === 'country' ) {
			$display_value = ( $country === 'custom' ) ? $text : $country;
		} else {
			$display_value = $text;
		}

		$td_class = ( $type === 'price' ) ? ' class="mwp-price-cell"' : '';
		echo '<td' . $td_class . '>';

		switch ( $type ) {
			case 'pill_std':
				echo '<span class="mwp-pill std">' . esc_html( $display_value ) . '</span>';
				break;
			case 'pill_eco':
				echo '<span class="mwp-pill eco">' . esc_html( $display_value ) . '</span>';
				break;
			case 'pill_pre':
				echo '<span class="mwp-pill pre">' . esc_html( $display_value ) . '</span>';
				break;
			case 'pill_no':
				echo '<span class="mwp-pill no">' . esc_html( $display_value ) . '</span>';
				break;
			default:
				echo wp_kses_post( $display_value );
				break;
		}

		echo '</td>';
	}

	protected function render() {
		$settings   = $this->get_settings_for_display();
		$presets    = $this->get_presets_data();
		$preset_key = ! empty( $settings['table_preset'] ) ? $settings['table_preset'] : 'brands';

		// تشخیص تنظیمات قالب انتخابی
		if ( $preset_key !== 'custom' && isset( $presets[ $preset_key ] ) ) {
			$active_preset  = $presets[ $preset_key ];
			$cols_count     = $active_preset['cols'];
			$default_tabs   = $active_preset['tabs'];
			$headers        = $active_preset['headers'];
			$caption        = $active_preset['caption'];
			$rows           = isset( $settings[ 'rows_' . $preset_key ] ) ? $settings[ 'rows_' . $preset_key ] : $active_preset['rows'];
		} else {
			$cols_count     = intval( $settings['custom_columns_count'] );
			$default_tabs   = true;
			$headers        = [ 'ستون اول', 'ستون دوم', 'ستون سوم', 'ستون چهارم', 'ستون پنجم' ];
			$caption        = '';
			$rows           = isset( $settings['rows_custom'] ) ? $settings['rows_custom'] : [];
		}

		// بررسی بازنویسی دستی سرستون‌ها و کپشن در صورت تمایل کاربر
		if ( $settings['override_headers'] === 'yes' ) {
			for ( $i = 1; $i <= $cols_count; $i++ ) {
				if ( ! empty( $settings[ "custom_th_{$i}" ] ) ) {
					$headers[ $i - 1 ] = $settings[ "custom_th_{$i}" ];
				}
			}
			if ( isset( $settings['custom_caption'] ) ) {
				$caption = $settings['custom_caption'];
			}
		}

		// بررسی وضعیت نمایش تب‌ها
		$tabs_mode = ! empty( $settings['tabs_mode'] ) ? $settings['tabs_mode'] : 'auto';
		if ( $tabs_mode === 'auto' ) {
			$show_tabs = $default_tabs;
		} else {
			$show_tabs = ( $tabs_mode === 'yes' );
		}

		$is_sticky = ( $settings['sticky_first_col'] === 'yes' ) ? ' is-sticky-col' : '';
		?>
		<div class="mwp-table-wrapper">

			<?php if ( $show_tabs && ! empty( $settings['tabs_list'] ) ) : ?>
				<div class="mwp-tabs" role="tablist" aria-label="فیلتر جدول">
					<?php foreach ( $settings['tabs_list'] as $index => $tab ) : 
						$is_selected = ( $index === 0 ) ? 'true' : 'false';
						$filter_key  = ! empty( $tab['tab_key'] ) ? $tab['tab_key'] : 'all';
					?>
						<button type="button" class="mwp-tab" role="tab" aria-selected="<?php echo esc_attr( $is_selected ); ?>" data-filter="<?php echo esc_attr( $filter_key ); ?>">
							<?php echo esc_html( $tab['tab_title'] ); ?>
						</button>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>

			<div class="mwp-tbl-container">
				<table class="mwp-table<?php echo esc_attr( $is_sticky ); ?>">
					<thead>
						<tr>
							<?php for ( $i = 0; $i < $cols_count; $i++ ) : ?>
								<th scope="col"><?php echo esc_html( isset( $headers[ $i ] ) ? $headers[ $i ] : '' ); ?></th>
							<?php endfor; ?>
						</tr>
					</thead>
					<tbody>
						<?php if ( ! empty( $rows ) ) : ?>
							<?php foreach ( $rows as $row ) : 
								$row_classes = ( ! empty( $row['row_highlight'] ) && $row['row_highlight'] === 'yes' ) ? ' class="mwp-row-hl"' : '';
								$row_cats    = ! empty( $row['row_filter_keys'] ) ? $row['row_filter_keys'] : '';
							?>
								<tr<?php echo $row_classes; ?> data-categories="<?php echo esc_attr( $row_cats ); ?>">
									<?php
									for ( $c = 1; $c <= $cols_count; $c++ ) {
										$this->render_table_cell( $row, $c );
									}
									?>
								</tr>
							<?php endforeach; ?>
						<?php endif; ?>
					</tbody>
				</table>
			</div>

			<?php if ( ! empty( $caption ) ) : ?>
				<p class="mwp-table-caption"><?php echo wp_kses_post( $caption ); ?></p>
			<?php endif; ?>

		</div>
		<?php
	}
}