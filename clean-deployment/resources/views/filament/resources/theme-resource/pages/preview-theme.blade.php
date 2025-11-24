<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <title>معاينة الثيم: {{ $record->name }}</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- Theme CSS -->
    <style>
        {!! $this->getThemeCSS() !!}
    </style>
    
    <!-- Additional Theme Styles -->
    <style>
        /* Preview specific styles */
        .preview-header {
            background: var(--theme-background);
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
            padding: 1rem 0;
            position: sticky;
            top: 0;
            z-index: 100;
        }
        
        .preview-nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1rem;
        }
        
        .preview-logo {
            font-weight: 700;
            font-size: 1.25rem;
            color: var(--theme-primary);
        }
        
        .preview-nav-links {
            display: flex;
            gap: 2rem;
            list-style: none;
            margin: 0;
            padding: 0;
        }
        
        .preview-nav-links a {
            color: var(--theme-text);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }
        
        .preview-nav-links a:hover {
            color: var(--theme-primary);
        }
        
        .theme-info {
            background: var(--theme-surface);
            padding: 2rem;
            margin-bottom: 2rem;
            border-radius: var(--border-radius);
        }
        
        .theme-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 2rem;
        }
        
        .stat-card {
            background: var(--theme-background);
            padding: 1.5rem;
            border-radius: var(--border-radius);
            text-align: center;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }
        
        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            color: var(--theme-primary);
        }
        
        .stat-label {
            color: var(--theme-secondary);
            font-weight: 500;
        }
        
        .demo-section {
            margin-bottom: 4rem;
        }
        
        .demo-section h2 {
            color: var(--theme-primary);
            margin-bottom: 1rem;
            font-size: 1.5rem;
        }
        
        .feature-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
        }
        
        .feature-card {
            background: var(--theme-surface);
            padding: 1.5rem;
            border-radius: var(--border-radius);
            box-shadow: var(--card-shadow);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
        }
        
        .feature-icon {
            width: 50px;
            height: 50px;
            background: var(--theme-primary);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }
        
        .pricing-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2rem;
            margin-top: 2rem;
        }
        
        .pricing-card {
            background: var(--theme-surface);
            border-radius: var(--border-radius);
            padding: 2rem;
            text-align: center;
            position: relative;
            box-shadow: var(--card-shadow);
            transition: transform 0.3s ease;
        }
        
        .pricing-card.featured {
            transform: scale(1.05);
            border: 2px solid var(--theme-primary);
        }
        
        .pricing-card:hover {
            transform: translateY(-10px);
        }
        
        .pricing-card.featured:hover {
            transform: scale(1.05) translateY(-10px);
        }
        
        .price {
            font-size: 3rem;
            font-weight: 700;
            color: var(--theme-primary);
            margin: 1rem 0;
        }
        
        .price-unit {
            font-size: 1rem;
            color: var(--theme-secondary);
        }
        
        .testimonial-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
        }
        
        .testimonial-card {
            background: var(--theme-surface);
            padding: 2rem;
            border-radius: var(--border-radius);
            box-shadow: var(--card-shadow);
            position: relative;
        }
        
        .testimonial-quote {
            font-size: 1.1rem;
            font-style: italic;
            margin-bottom: 1rem;
            color: var(--theme-text);
        }
        
        .testimonial-author {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
        .author-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: var(--theme-primary);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
        }
        
        .author-info h4 {
            margin: 0;
            color: var(--theme-text);
        }
        
        .author-info p {
            margin: 0;
            color: var(--theme-secondary);
            font-size: 0.9rem;
        }
        
        .form-demo {
            background: var(--theme-surface);
            padding: 2rem;
            border-radius: var(--border-radius);
            box-shadow: var(--card-shadow);
            max-width: 500px;
            margin: 2rem auto;
        }
        
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: var(--theme-text);
        }
        
        .form-input {
            width: 100%;
            padding: 0.75rem;
            border: 2px solid rgba(0, 0, 0, 0.1);
            border-radius: var(--border-radius);
            font-size: 1rem;
            transition: border-color 0.3s ease;
        }
        
        .form-input:focus {
            outline: none;
            border-color: var(--theme-primary);
        }
        
        .back-to-admin {
            position: fixed;
            top: 20px;
            left: 20px;
            z-index: 1000;
            background: var(--theme-primary);
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: var(--border-radius);
            text-decoration: none;
            font-weight: 500;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
        }
        
        .back-to-admin:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3);
            color: white;
        }
        
        /* Mobile Responsive */
        @media (max-width: 768px) {
            .preview-nav-links {
                display: none;
            }
            
            .theme-stats {
                grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            }
            
            .pricing-card.featured {
                transform: none;
            }
            
            .pricing-card.featured:hover {
                transform: translateY(-10px);
            }
            
            .back-to-admin {
                position: relative;
                top: auto;
                left: auto;
                margin-bottom: 1rem;
                display: inline-block;
            }
        }
        
        /* Print Styles */
        @media print {
            .preview-header,
            .back-to-admin {
                display: none !important;
            }
            
            .container {
                max-width: none !important;
                padding: 0 !important;
            }
        }
    </style>
</head>
<body class="theme-preview">
    <!-- Back to Admin Button -->
    <a href="{{ url('/admin') }}" class="back-to-admin">
        ← العودة للوحة التحكم
    </a>

    <!-- Navigation Header -->
    <header class="preview-header">
        <nav class="preview-nav">
            <div class="preview-logo">
                {{ $record->name }}
            </div>
            <ul class="preview-nav-links">
                <li><a href="#home">الرئيسية</a></li>
                <li><a href="#features">المميزات</a></li>
                <li><a href="#pricing">الأسعار</a></li>
                <li><a href="#testimonials">آراء العملاء</a></li>
                <li><a href="#contact">اتصل بنا</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <!-- Hero Section -->
        <section class="hero animate-on-scroll" id="home">
            <div class="container">
                <h1>معاينة ثيم {{ $record->name }}</h1>
                <p>{{ $this->getThemeDescription() }}</p>
                <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
                    <a href="#features" class="btn-primary">استكشف المميزات</a>
                    <a href="#contact" class="btn-secondary">جرب النموذج</a>
                </div>
            </div>
        </section>

        <!-- Theme Information -->
        <section class="theme-info">
            <div class="container">
                <h2 style="text-align: center; margin-bottom: 2rem; color: var(--theme-primary);">معلومات الثيم</h2>
                
                <div class="theme-stats">
                    <div class="stat-card">
                        <div class="stat-number">{{ $this->getThemeVersion() }}</div>
                        <div class="stat-label">الإصدار</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number">{{ $this->getLayoutTypeDisplay() }}</div>
                        <div class="stat-label">نوع التخطيط</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number">{{ $this->getColorSchemeDisplay() }}</div>
                        <div class="stat-label">نظام الألوان</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number">{{ $this->getThemeAuthor() }}</div>
                        <div class="stat-label">المؤلف</div>
                    </div>
                </div>

                <div style="text-align: center; margin-bottom: 2rem;">
                    @if($record->getFirstMediaUrl('preview_image'))
                        <img src="{{ $record->getFirstMediaUrl('preview_image') }}" 
                             alt="معاينة الثيم" 
                             style="max-width: 400px; height: auto; border-radius: var(--border-radius); box-shadow: var(--card-shadow);">
                    @else
                        <div style="width: 400px; height: 300px; background: var(--theme-surface); border-radius: var(--border-radius); display: flex; align-items: center; justify-content: center; margin: 0 auto; color: var(--theme-secondary);">
                            لا توجد صورة معاينة
                        </div>
                    @endif
                </div>

                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin-bottom: 2rem;">
                    <div style="text-align: center;">
                        <strong>يدعم الرسوم المتحركة:</strong><br>
                        <span style="color: var(--theme-success);">
                            {{ $record->animations_enabled ? '✅ مفعل' : '❌ غير مفعل' }}
                        </span>
                    </div>
                    <div style="text-align: center;">
                        <strong>الثيم مفعل:</strong><br>
                        <span style="color: {{ $record->is_active ? 'var(--theme-success)' : 'var(--theme-error)' }};">
                            {{ $record->is_active ? '✅ مفعل' : '❌ غير مفعل' }}
                        </span>
                    </div>
                    <div style="text-align: center;">
                        <strong>الثيم الافتراضي:</strong><br>
                        <span style="color: var(--theme-warning);">
                            {{ $record->is_default ? '⭐ افتراضي' : '➖ عادي' }}
                        </span>
                    </div>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section class="demo-section" id="features">
            <div class="container">
                <h2 class="text-center animate-on-scroll">مميزات هذا الثيم</h2>
                <p class="text-center animate-on-scroll" style="margin-bottom: 3rem; font-size: 1.1rem; color: var(--theme-secondary);">
                    استكشف المميزات والتصميمات المختلفة التي يدعمها هذا الثيم
                </p>
                
                <div class="feature-grid">
                    <div class="feature-card animate-on-scroll">
                        <div class="feature-icon">🎨</div>
                        <h3>نظام ألوان مرن</h3>
                        <p>يدعم نظام ألوان قابل للتخصيص مع ألوان متدرجة وتأثيرات بصرية مميزة</p>
                    </div>
                    
                    <div class="feature-card animate-on-scroll">
                        <div class="feature-icon">📱</div>
                        <h3>تصميم متجاوب</h3>
                        <p>يتكيف مع جميع الأجهزة والشاشات من الهواتف الذكية إلى شاشات سطح المكتب</p>
                    </div>
                    
                    <div class="feature-card animate-on-scroll">
                        <div class="feature-icon">⚡</div>
                        <h3>أداء عالي</h3>
                        <p>محسن للسرعة والأداء مع تحميل سريع وتفاعل سلس</p>
                    </div>
                    
                    <div class="feature-card animate-on-scroll">
                        <div class="feature-icon">🎭</div>
                        <h3>رسوم متحركة</h3>
                        <p>رسوم متحركة جميلة ومؤثرات بصرية تفاعلية لتحسين تجربة المستخدم</p>
                    </div>
                    
                    <div class="feature-card animate-on-scroll">
                        <div class="feature-icon">🌍</div>
                        <h3>دعم RTL</h3>
                        <p>دعم كامل للغة العربية مع اتجاه النص من اليمين إلى اليسار</p>
                    </div>
                    
                    <div class="feature-card animate-on-scroll">
                        <div class="feature-icon">🔧</div>
                        <h3>سهولة التخصيص</h3>
                        <p>واجهة سهلة لتخصيص الألوان والخطوط والتخطيطات</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Pricing Section -->
        <section class="demo-section" id="pricing">
            <div class="container">
                <h2 class="text-center animate-on-scroll">عروض الأسعار</h2>
                <p class="text-center animate-on-scroll" style="margin-bottom: 3rem; font-size: 1.1rem; color: var(--theme-secondary);">
                    اختر الخطة التي تناسب احتياجاتك
                </p>
                
                <div class="pricing-grid">
                    <div class="pricing-card animate-on-scroll">
                        <h3>الخطة الأساسية</h3>
                        <div class="price">
                            299
                            <span class="price-unit">ر.س/شهر</span>
                        </div>
                        <ul style="text-align: right; list-style: none; padding: 0;">
                            <li style="margin-bottom: 0.5rem;">✅ صفحة رئيسية</li>
                            <li style="margin-bottom: 0.5rem;">✅ صفحة الخدمات</li>
                            <li style="margin-bottom: 0.5rem;">✅ صفحة حجز المواعيد</li>
                            <li style="margin-bottom: 0.5rem;">✅ 3 ألوان مخصصة</li>
                            <li style="margin-bottom: 0.5rem;">✅ دعم فني أساسي</li>
                            <li style="margin-bottom: 0.5rem;">✅ تحديثات شهرية</li>
                        </ul>
                        <button class="btn-primary" style="margin-top: 1.5rem;">اختر الخطة</button>
                    </div>
                    
                    <div class="pricing-card featured animate-on-scroll">
                        <div style="background: var(--theme-primary); color: white; padding: 0.5rem; margin: -2rem -2rem 1rem -2rem; text-align: center; font-weight: 600;">
                            الأكثر شعبية
                        </div>
                        <h3>الخطة المتقدمة</h3>
                        <div class="price">
                            599
                            <span class="price-unit">ر.س/شهر</span>
                        </div>
                        <ul style="text-align: right; list-style: none; padding: 0;">
                            <li style="margin-bottom: 0.5rem;">✅ جميع مميزات الخطة الأساسية</li>
                            <li style="margin-bottom: 0.5rem;">✅ نظام إدارة المحتوى</li>
                            <li style="margin-bottom: 0.5rem;">✅ صفحات غير محدودة</li>
                            <li style="margin-bottom: 0.5rem;">✅ 10+ ثيمات متقدمة</li>
                            <li style="margin-bottom: 0.5rem;">✅ رسوم متحركة مخصصة</li>
                            <li style="margin-bottom: 0.5rem;">✅ دعم فني أولوية</li>
                            <li style="margin-bottom: 0.5rem;">✅ تحديثات أسبوعية</li>
                        </ul>
                        <button class="btn-primary" style="margin-top: 1.5rem;">اختر الخطة</button>
                    </div>
                    
                    <div class="pricing-card animate-on-scroll">
                        <h3>الخطة الاحترافية</h3>
                        <div class="price">
                            999
                            <span class="price-unit">ر.س/شهر</span>
                        </div>
                        <ul style="text-align: right; list-style: none; padding: 0;">
                            <li style="margin-bottom: 0.5rem;">✅ جميع مميزات الخطة المتقدمة</li>
                            <li style="margin-bottom: 0.5rem;">✅ تخصيص كامل للثيم</li>
                            <li style="margin-bottom: 0.5rem;">✅ نظام السحب والإفلات</li>
                            <li style="margin-bottom: 0.5rem;">✅ تطبيقات ويب متقدمة</li>
                            <li style="margin-bottom: 0.5rem;">✅ تحليلات مفصلة</li>
                            <li style="margin-bottom: 0.5rem;">✅ دعم فني مخصص</li>
                            <li style="margin-bottom: 0.5rem;">✅ تحديثات فورية</li>
                            <li style="margin-bottom: 0.5rem;">✅ تدريب مجاني</li>
                        </ul>
                        <button class="btn-primary" style="margin-top: 1.5rem;">اختر الخطة</button>
                    </div>
                </div>
            </div>
        </section>

        <!-- Testimonials Section -->
        <section class="demo-section" id="testimonials">
            <div class="container">
                <h2 class="text-center animate-on-scroll">آراء عملائنا</h2>
                <p class="text-center animate-on-scroll" style="margin-bottom: 3rem; font-size: 1.1rem; color: var(--theme-secondary);">
                    اكتشف ما يقوله عملاؤنا عن تجربتهم مع هذا الثيم
                </p>
                
                <div class="testimonial-grid">
                    <div class="testimonial-card animate-on-scroll">
                        <div class="testimonial-quote">
                            "ثيم رائع وسهل الاستخدام! التصميم جميل ومتجاوب مع جميع الأجهزة. أنصح به بشدة."
                        </div>
                        <div class="testimonial-author">
                            <div class="author-avatar">أ</div>
                            <div class="author-info">
                                <h4>أحمد محمد</h4>
                                <p>مدير عيادة</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="testimonial-card animate-on-scroll">
                        <div class="testimonial-quote">
                            "المميزة الأفضل هي سهولة التخصيص والألوان الجميلة. دعم العملاء ممتاز جداً."
                        </div>
                        <div class="testimonial-author">
                            <div class="author-avatar">س</div>
                            <div class="author-info">
                                <h4>سارة العلي</h4>
                                <p>طبيبة عيون</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="testimonial-card animate-on-scroll">
                        <div class="testimonial-quote">
                            "تجربة استخدام مذهلة! الثيم سريع وآمن، والأهم أنه يدعم اللغة العربية بشكل مثالي."
                        </div>
                        <div class="testimonial-author">
                            <div class="author-avatar">م</div>
                            <div class="author-info">
                                <h4>محمد الأحمد</h4>
                                <p>استشاري</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Contact Form Demo -->
        <section class="demo-section" id="contact">
            <div class="container">
                <h2 class="text-center animate-on-scroll">جرب نموذج التواصل</h2>
                <p class="text-center animate-on-scroll" style="margin-bottom: 3rem; font-size: 1.1rem; color: var(--theme-secondary);">
                    اختبر تصميم النماذج والعناصر التفاعلية
                </p>
                
                <form class="form-demo animate-on-scroll">
                    <div class="form-group">
                        <label class="form-label" for="name">الاسم الكامل</label>
                        <input type="text" id="name" name="name" class="form-input" placeholder="أدخل اسمك الكامل" required>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="email">البريد الإلكتروني</label>
                        <input type="email" id="email" name="email" class="form-input" placeholder="example@domain.com" required>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="phone">رقم الهاتف</label>
                        <input type="tel" id="phone" name="phone" class="form-input" placeholder="05xxxxxxxx" required>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="service">نوع الخدمة</label>
                        <select id="service" name="service" class="form-input" required>
                            <option value="">اختر نوع الخدمة</option>
                            <option value="consultation">استشارة طبية</option>
                            <option value="surgery">عملية جراحية</option>
                            <option value="checkup">فحص شامل</option>
                            <option value="followup">متابعة</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="message">رسالتك</label>
                        <textarea id="message" name="message" class="form-input" rows="4" placeholder="اكتب رسالتك هنا..."></textarea>
                    </div>
                    
                    <div style="text-align: center;">
                        <button type="submit" class="btn-primary">إرسال الرسالة</button>
                    </div>
                </form>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="demo-section" style="background: var(--theme-primary); color: white; padding: 4rem 0; margin: 4rem 0;">
            <div class="container" style="text-align: center;">
                <h2 style="color: white; margin-bottom: 1rem;">جاهز لاستخدام هذا الثيم؟</h2>
                <p style="font-size: 1.2rem; margin-bottom: 2rem; opacity: 0.9;">
                    ابدأ رحلتك مع تصميم مميز ومتجاوب
                </p>
                <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
                    <button class="btn-primary" style="background: white; color: var(--theme-primary);">
                        تفعيل الثيم
                    </button>
                    <button class="btn-secondary" style="background: transparent; color: white; border: 2px solid white;">
                        تخصيص إضافي
                    </button>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <p>&copy; 2024 {{ $record->name }}. جميع الحقوق محفوظة.</p>
            <p>هذا عرض توضيحي لمعاينة الثيم وتطبيقاته المختلفة.</p>
        </div>
    </footer>

    <!-- Theme JavaScript -->
    <script>
        {!! $this->getThemeJS() !!}
        
        // Additional preview functionality
        document.addEventListener('DOMContentLoaded', function() {
            // Add smooth scrolling for anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });

            // Form submission demo
            const form = document.querySelector('.form-demo');
            if (form) {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    alert('شكراً لك! تم إرسال رسالتك بنجاح. هذه مجرد عرض توضيحي.');
                });
            }

            // Button interactions demo
            document.querySelectorAll('.pricing-card button, .btn-primary, .btn-secondary').forEach(button => {
                button.addEventListener('click', function(e) {
                    if (!this.form) { // Only if it's not a form submit button
                        e.preventDefault();
                        alert('هذا مجرد عرض توضيحي لعناصر الثيم!');
                    }
                });
            });

            // Add loading states
            document.querySelectorAll('button').forEach(button => {
                button.addEventListener('click', function() {
                    if (!this.form) {
                        const originalText = this.textContent;
                        this.textContent = 'جاري التحميل...';
                        this.disabled = true;
                        
                        setTimeout(() => {
                            this.textContent = originalText;
                            this.disabled = false;
                        }, 1500);
                    }
                });
            });
        });
    </script>
</body>
</html>