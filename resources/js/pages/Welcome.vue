<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { dashboard, login, register } from '@/routes';
import { ref, onMounted } from 'vue';

withDefaults(
    defineProps<{
        canRegister: boolean;
    }>(),
    {
        canRegister: true,
    },
);

const features = ref([
    {
        icon: '⚡',
        title: 'Lightning Fast',
        description: 'Built with modern technologies for optimal performance',
        gradient: 'from-yellow-400 to-orange-500'
    },
    {
        icon: '🔒',
        title: 'Secure by Default',
        description: 'Enterprise-grade security features built-in',
        gradient: 'from-blue-400 to-indigo-500'
    },
    {
        icon: '🎨',
        title: 'Beautiful UI',
        description: 'Crafted with attention to detail and user experience',
        gradient: 'from-pink-400 to-purple-500'
    },
    {
        icon: '🚀',
        title: 'Scalable',
        description: 'Designed to grow with your business needs',
        gradient: 'from-green-400 to-teal-500'
    }
]);

const stats = ref([
    { value: '99.9%', label: 'Uptime' },
    { value: '<50ms', label: 'Response Time' },
    { value: '24/7', label: 'Support' },
    { value: '10K+', label: 'Users' }
]);

// Animated particles
const particles = ref<Array<{ x: number; y: number; size: number; duration: number }>>([]);

onMounted(() => {
    // Generate random particles for background animation
    for (let i = 0; i < 30; i++) {
        particles.value.push({
            x: Math.random() * 100,
            y: Math.random() * 100,
            size: Math.random() * 4 + 2,
            duration: Math.random() * 20 + 10
        });
    }
});
</script>

<template>
    <Head title="Welcome">
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Fira+Code:wght@400;500&display=swap" rel="stylesheet" />
    </Head>

    <div class="welcome-page">
        <!-- Animated Background -->
        <div class="background-animation">
            <div 
                v-for="(particle, index) in particles" 
                :key="index"
                class="particle"
                :style="{
                    left: `${particle.x}%`,
                    top: `${particle.y}%`,
                    width: `${particle.size}px`,
                    height: `${particle.size}px`,
                    animationDuration: `${particle.duration}s`
                }"
            ></div>
        </div>

        <!-- Navigation -->
        <nav class="navigation">
            <div class="nav-container">
                <div class="logo">
                    <div class="logo-icon">
                        <svg viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect width="40" height="40" rx="8" fill="url(#logoGradient)"/>
                            <path d="M12 20L18 26L28 14" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                            <defs>
                                <linearGradient id="logoGradient" x1="0" y1="0" x2="40" y2="40">
                                    <stop offset="0%" stop-color="#8B5CF6"/>
                                    <stop offset="100%" stop-color="#EC4899"/>
                                </linearGradient>
                            </defs>
                        </svg>
                    </div>
                    <span class="logo-text">VueStarter</span>
                </div>

                <div class="nav-actions">
                    <Link
                        v-if="$page.props.auth.user"
                        :href="dashboard()"
                        class="btn btn-primary"
                    >
                        Go to Dashboard
                    </Link>
                    <template v-else>
                        <Link :href="login()" class="btn btn-ghost">
                            Log in
                        </Link>
                        <Link v-if="canRegister" :href="register()" class="btn btn-primary">
                            Get Started
                        </Link>
                    </template>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <section class="hero-section">
            <div class="hero-container">
                <div class="hero-content">
                    <div class="hero-badge">
                        <span class="badge-icon">✨</span>
                        <span>New Features Available</span>
                    </div>
                    
                    <h1 class="hero-title">
                        Build Amazing
                        <span class="gradient-text">Applications</span>
                        Faster Than Ever
                    </h1>
                    
                    <p class="hero-description">
                        A modern, powerful platform designed for developers who want to create 
                        exceptional web applications without the hassle. Get started in minutes.
                    </p>

                    <div class="hero-actions">
                        <Link 
                            v-if="!$page.props.auth.user"
                            :href="register()" 
                            class="btn btn-large btn-gradient"
                        >
                            <span>Start Building</span>
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                                <path d="M7 4L13 10L7 16" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </Link>
                        <Link 
                            v-else
                            :href="dashboard()" 
                            class="btn btn-large btn-gradient"
                        >
                            <span>Open Dashboard</span>
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                                <path d="M7 4L13 10L7 16" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </Link>
                        <button class="btn btn-large btn-outline">
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                                <path d="M10 4V10L14 12" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                <circle cx="10" cy="10" r="7" stroke="currentColor" stroke-width="2"/>
                            </svg>
                            <span>Watch Demo</span>
                        </button>
                    </div>

                    <!-- Stats -->
                    <div class="stats-grid">
                        <div 
                            v-for="(stat, index) in stats" 
                            :key="index"
                            class="stat-item"
                            :style="{ animationDelay: `${index * 100}ms` }"
                        >
                            <div class="stat-value">{{ stat.value }}</div>
                            <div class="stat-label">{{ stat.label }}</div>
                        </div>
                    </div>
                </div>

                <div class="hero-visual">
                    <div class="visual-card card-1">
                        <div class="card-header">
                            <div class="card-dots">
                                <span class="dot dot-red"></span>
                                <span class="dot dot-yellow"></span>
                                <span class="dot dot-green"></span>
                            </div>
                            <div class="card-title">Dashboard Preview</div>
                        </div>
                        <div class="card-content">
                            <div class="code-line">
                                <span class="code-keyword">const</span>
                                <span class="code-variable"> app</span>
                                <span> = </span>
                                <span class="code-string">'amazing'</span>
                            </div>
                            <div class="code-line">
                                <span class="code-keyword">function</span>
                                <span class="code-function"> build</span>
                                <span>() {</span>
                            </div>
                            <div class="code-line code-indent">
                                <span class="code-keyword">return</span>
                                <span class="code-string"> 'success'</span>
                            </div>
                            <div class="code-line">
                                <span>}</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="visual-card card-2">
                        <div class="mini-chart">
                            <div class="chart-bar" style="height: 60%"></div>
                            <div class="chart-bar" style="height: 80%"></div>
                            <div class="chart-bar" style="height: 45%"></div>
                            <div class="chart-bar" style="height: 90%"></div>
                            <div class="chart-bar" style="height: 70%"></div>
                        </div>
                        <div class="mini-stats">
                            <div class="mini-stat">
                                <span class="mini-stat-label">Performance</span>
                                <span class="mini-stat-value">98%</span>
                            </div>
                        </div>
                    </div>

                    <div class="visual-card card-3">
                        <div class="status-indicator">
                            <div class="status-dot pulse"></div>
                            <span>All Systems Operational</span>
                        </div>
                    </div>

                    <!-- Floating Elements -->
                    <div class="floating-element element-1">
                        <svg width="60" height="60" viewBox="0 0 60 60" fill="none">
                            <circle cx="30" cy="30" r="28" stroke="url(#gradient1)" stroke-width="4"/>
                            <path d="M20 30L27 37L40 23" stroke="url(#gradient1)" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
                            <defs>
                                <linearGradient id="gradient1" x1="0" y1="0" x2="60" y2="60">
                                    <stop offset="0%" stop-color="#8B5CF6"/>
                                    <stop offset="100%" stop-color="#EC4899"/>
                                </linearGradient>
                            </defs>
                        </svg>
                    </div>

                    <div class="floating-element element-2">
                        <svg width="50" height="50" viewBox="0 0 50 50" fill="none">
                            <rect width="50" height="50" rx="12" fill="url(#gradient2)" opacity="0.2"/>
                            <path d="M25 15L31 25H19L25 15Z" fill="url(#gradient2)"/>
                            <circle cx="25" cy="32" r="3" fill="url(#gradient2)"/>
                            <defs>
                                <linearGradient id="gradient2" x1="0" y1="0" x2="50" y2="50">
                                    <stop offset="0%" stop-color="#3B82F6"/>
                                    <stop offset="100%" stop-color="#8B5CF6"/>
                                </linearGradient>
                            </defs>
                        </svg>
                    </div>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section class="features-section">
            <div class="features-container">
                <div class="section-header">
                    <h2 class="section-title">Everything You Need</h2>
                    <p class="section-description">
                        Powerful features to help you build better, ship faster
                    </p>
                </div>

                <div class="features-grid">
                    <div 
                        v-for="(feature, index) in features" 
                        :key="index"
                        class="feature-card"
                        :style="{ animationDelay: `${index * 150}ms` }"
                    >
                        <div class="feature-icon" :class="`bg-gradient-to-br ${feature.gradient}`">
                            <span>{{ feature.icon }}</span>
                        </div>
                        <h3 class="feature-title">{{ feature.title }}</h3>
                        <p class="feature-description">{{ feature.description }}</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="cta-section">
            <div class="cta-container">
                <div class="cta-content">
                    <h2 class="cta-title">Ready to Get Started?</h2>
                    <p class="cta-description">
                        Join thousands of developers building amazing applications
                    </p>
                    <div class="cta-actions">
                        <Link 
                            v-if="!$page.props.auth.user"
                            :href="register()" 
                            class="btn btn-large btn-white"
                        >
                            Create Your Account
                        </Link>
                        <Link 
                            v-else
                            :href="dashboard()" 
                            class="btn btn-large btn-white"
                        >
                            Go to Dashboard
                        </Link>
                    </div>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="footer">
            <div class="footer-container">
                <div class="footer-content">
                    <div class="footer-brand">
                        <div class="logo">
                            <div class="logo-icon">
                                <svg viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect width="40" height="40" rx="8" fill="url(#footerLogoGradient)"/>
                                    <path d="M12 20L18 26L28 14" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                                    <defs>
                                        <linearGradient id="footerLogoGradient" x1="0" y1="0" x2="40" y2="40">
                                            <stop offset="0%" stop-color="#8B5CF6"/>
                                            <stop offset="100%" stop-color="#EC4899"/>
                                        </linearGradient>
                                    </defs>
                                </svg>
                            </div>
                            <span class="logo-text">VueStarter</span>
                        </div>
                        <p class="footer-tagline">Building the future, one line at a time.</p>
                    </div>

                    <div class="footer-links">
                        <div class="footer-column">
                            <h4 class="footer-heading">Product</h4>
                            <a href="#" class="footer-link">Features</a>
                            <a href="#" class="footer-link">Pricing</a>
                            <a href="#" class="footer-link">Changelog</a>
                        </div>

                        <div class="footer-column">
                            <h4 class="footer-heading">Company</h4>
                            <a href="#" class="footer-link">About</a>
                            <a href="#" class="footer-link">Blog</a>
                            <a href="#" class="footer-link">Careers</a>
                        </div>

                        <div class="footer-column">
                            <h4 class="footer-heading">Resources</h4>
                            <a href="#" class="footer-link">Documentation</a>
                            <a href="#" class="footer-link">Support</a>
                            <a href="#" class="footer-link">Contact</a>
                        </div>
                    </div>
                </div>

                <div class="footer-bottom">
                    <p>&copy; 2026 VueStarter. All rights reserved.</p>
                    <div class="footer-social">
                        <a href="#" class="social-link">Twitter</a>
                        <a href="#" class="social-link">GitHub</a>
                        <a href="#" class="social-link">Discord</a>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</template>

<style scoped>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

.welcome-page {
    font-family: 'Poppins', sans-serif;
    background: linear-gradient(135deg, #0f0f23 0%, #1a1a3e 50%, #0f0f23 100%);
    min-height: 100vh;
    color: #ffffff;
    overflow-x: hidden;
    position: relative;
}

/* Background Animation */
.background-animation {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    pointer-events: none;
    z-index: 0;
    overflow: hidden;
}

.particle {
    position: absolute;
    background: radial-gradient(circle, rgba(139, 92, 246, 0.4) 0%, transparent 70%);
    border-radius: 50%;
    animation: float infinite ease-in-out;
    opacity: 0.6;
}

@keyframes float {
    0%, 100% {
        transform: translateY(0) translateX(0) scale(1);
        opacity: 0.6;
    }
    33% {
        transform: translateY(-30px) translateX(20px) scale(1.1);
        opacity: 0.8;
    }
    66% {
        transform: translateY(-10px) translateX(-20px) scale(0.9);
        opacity: 0.4;
    }
}

/* Navigation */
.navigation {
    position: relative;
    z-index: 100;
    padding: 1.5rem 0;
    background: rgba(15, 15, 35, 0.8);
    backdrop-filter: blur(20px);
    border-bottom: 1px solid rgba(139, 92, 246, 0.1);
}

.nav-container {
    max-width: 1280px;
    margin: 0 auto;
    padding: 0 2rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.logo {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.logo-icon {
    width: 40px;
    height: 40px;
}

.logo-icon svg {
    width: 100%;
    height: 100%;
}

.logo-text {
    font-size: 1.5rem;
    font-weight: 700;
    background: linear-gradient(135deg, #8B5CF6 0%, #EC4899 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.nav-actions {
    display: flex;
    gap: 1rem;
    align-items: center;
}

/* Buttons */
.btn {
    padding: 0.75rem 1.5rem;
    border-radius: 0.75rem;
    font-weight: 600;
    font-size: 0.875rem;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    cursor: pointer;
    border: none;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    white-space: nowrap;
}

.btn-ghost {
    background: transparent;
    color: #ffffff;
    border: 1px solid rgba(255, 255, 255, 0.1);
}

.btn-ghost:hover {
    background: rgba(255, 255, 255, 0.05);
    border-color: rgba(139, 92, 246, 0.3);
}

.btn-primary {
    background: linear-gradient(135deg, #8B5CF6 0%, #EC4899 100%);
    color: #ffffff;
    box-shadow: 0 4px 20px rgba(139, 92, 246, 0.3);
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 30px rgba(139, 92, 246, 0.4);
}

.btn-large {
    padding: 1rem 2rem;
    font-size: 1rem;
}

.btn-gradient {
    background: linear-gradient(135deg, #8B5CF6 0%, #EC4899 100%);
    color: #ffffff;
    box-shadow: 0 10px 40px rgba(139, 92, 246, 0.3);
}

.btn-gradient:hover {
    transform: translateY(-3px);
    box-shadow: 0 15px 50px rgba(139, 92, 246, 0.5);
}

.btn-outline {
    background: rgba(255, 255, 255, 0.05);
    border: 2px solid rgba(139, 92, 246, 0.3);
    color: #ffffff;
}

.btn-outline:hover {
    background: rgba(139, 92, 246, 0.1);
    border-color: rgba(139, 92, 246, 0.5);
}

.btn-white {
    background: #ffffff;
    color: #0f0f23;
}

.btn-white:hover {
    transform: translateY(-3px);
    box-shadow: 0 15px 50px rgba(255, 255, 255, 0.3);
}

/* Hero Section */
.hero-section {
    position: relative;
    z-index: 10;
    padding: 6rem 0;
    min-height: calc(100vh - 100px);
    display: flex;
    align-items: center;
}

.hero-container {
    max-width: 1280px;
    margin: 0 auto;
    padding: 0 2rem;
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 4rem;
    align-items: center;
}

.hero-content {
    animation: slideInLeft 0.8s ease-out;
}

.hero-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1rem;
    background: rgba(139, 92, 246, 0.1);
    border: 1px solid rgba(139, 92, 246, 0.3);
    border-radius: 2rem;
    font-size: 0.875rem;
    margin-bottom: 2rem;
    animation: fadeIn 0.8s ease-out 0.2s backwards;
}

.badge-icon {
    font-size: 1.25rem;
}

.hero-title {
    font-size: 3.5rem;
    font-weight: 800;
    line-height: 1.2;
    margin-bottom: 1.5rem;
    animation: fadeIn 0.8s ease-out 0.3s backwards;
}

.gradient-text {
    background: linear-gradient(135deg, #8B5CF6 0%, #EC4899 50%, #F59E0B 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    display: block;
}

.hero-description {
    font-size: 1.25rem;
    line-height: 1.8;
    color: rgba(255, 255, 255, 0.7);
    margin-bottom: 2.5rem;
    animation: fadeIn 0.8s ease-out 0.4s backwards;
}

.hero-actions {
    display: flex;
    gap: 1rem;
    margin-bottom: 3rem;
    flex-wrap: wrap;
    animation: fadeIn 0.8s ease-out 0.5s backwards;
}

/* Stats Grid */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 2rem;
    padding-top: 2rem;
    border-top: 1px solid rgba(139, 92, 246, 0.2);
}

.stat-item {
    animation: fadeInUp 0.8s ease-out backwards;
}

.stat-value {
    font-size: 2rem;
    font-weight: 700;
    background: linear-gradient(135deg, #8B5CF6 0%, #EC4899 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin-bottom: 0.25rem;
}

.stat-label {
    font-size: 0.875rem;
    color: rgba(255, 255, 255, 0.6);
}

/* Hero Visual */
.hero-visual {
    position: relative;
    height: 600px;
    animation: slideInRight 0.8s ease-out;
}

.visual-card {
    position: absolute;
    background: rgba(255, 255, 255, 0.05);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(139, 92, 246, 0.2);
    border-radius: 1.5rem;
    padding: 1.5rem;
    animation: floatCard 6s ease-in-out infinite;
}

.card-1 {
    top: 10%;
    left: 0;
    width: 380px;
    z-index: 3;
    box-shadow: 0 20px 60px rgba(139, 92, 246, 0.2);
}

.card-2 {
    top: 40%;
    right: 0;
    width: 280px;
    z-index: 2;
    animation-delay: -2s;
}

.card-3 {
    bottom: 15%;
    left: 15%;
    width: 320px;
    z-index: 1;
    animation-delay: -4s;
}

.card-header {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 1rem;
    padding-bottom: 1rem;
    border-bottom: 1px solid rgba(139, 92, 246, 0.2);
}

.card-dots {
    display: flex;
    gap: 0.5rem;
}

.dot {
    width: 12px;
    height: 12px;
    border-radius: 50%;
}

.dot-red { background: #EF4444; }
.dot-yellow { background: #F59E0B; }
.dot-green { background: #10B981; }

.card-title {
    font-size: 0.875rem;
    color: rgba(255, 255, 255, 0.8);
}

.card-content {
    font-family: 'Fira Code', monospace;
    font-size: 0.875rem;
}

.code-line {
    margin-bottom: 0.5rem;
}

.code-indent {
    padding-left: 2rem;
}

.code-keyword { color: #C084FC; }
.code-variable { color: #60A5FA; }
.code-string { color: #34D399; }
.code-function { color: #F472B6; }

.mini-chart {
    display: flex;
    align-items: flex-end;
    gap: 0.5rem;
    height: 100px;
    margin-bottom: 1rem;
}

.chart-bar {
    flex: 1;
    background: linear-gradient(to top, #8B5CF6, #EC4899);
    border-radius: 0.25rem;
    animation: growBar 2s ease-out infinite;
}

.mini-stats {
    padding-top: 1rem;
    border-top: 1px solid rgba(139, 92, 246, 0.2);
}

.mini-stat {
    display: flex;
    justify-content: space-between;
}

.mini-stat-label {
    color: rgba(255, 255, 255, 0.6);
    font-size: 0.875rem;
}

.mini-stat-value {
    font-weight: 700;
    color: #10B981;
}

.status-indicator {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 1rem;
    background: rgba(16, 185, 129, 0.1);
    border-radius: 0.75rem;
}

.status-dot {
    width: 12px;
    height: 12px;
    background: #10B981;
    border-radius: 50%;
}

.status-dot.pulse {
    animation: pulse 2s ease-in-out infinite;
}

.floating-element {
    position: absolute;
    animation: rotate360 20s linear infinite;
}

.element-1 {
    top: 5%;
    right: 10%;
    animation: float 8s ease-in-out infinite;
}

.element-2 {
    bottom: 10%;
    right: 20%;
    animation: float 6s ease-in-out infinite 2s;
}

/* Features Section */
.features-section {
    position: relative;
    z-index: 10;
    padding: 6rem 0;
    background: rgba(255, 255, 255, 0.02);
}

.features-container {
    max-width: 1280px;
    margin: 0 auto;
    padding: 0 2rem;
}

.section-header {
    text-align: center;
    margin-bottom: 4rem;
}

.section-title {
    font-size: 3rem;
    font-weight: 800;
    margin-bottom: 1rem;
    background: linear-gradient(135deg, #ffffff 0%, rgba(255, 255, 255, 0.6) 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.section-description {
    font-size: 1.25rem;
    color: rgba(255, 255, 255, 0.6);
}

.features-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 2rem;
}

.feature-card {
    background: rgba(255, 255, 255, 0.05);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(139, 92, 246, 0.2);
    border-radius: 1.5rem;
    padding: 2rem;
    transition: all 0.3s ease;
    animation: fadeInUp 0.8s ease-out backwards;
}

.feature-card:hover {
    transform: translateY(-8px);
    border-color: rgba(139, 92, 246, 0.5);
    box-shadow: 0 20px 60px rgba(139, 92, 246, 0.3);
}

.feature-icon {
    width: 4rem;
    height: 4rem;
    border-radius: 1rem;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
    margin-bottom: 1.5rem;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
}

.feature-title {
    font-size: 1.5rem;
    font-weight: 700;
    margin-bottom: 0.75rem;
}

.feature-description {
    color: rgba(255, 255, 255, 0.7);
    line-height: 1.6;
}

/* CTA Section */
.cta-section {
    position: relative;
    z-index: 10;
    padding: 6rem 0;
}

.cta-container {
    max-width: 1280px;
    margin: 0 auto;
    padding: 0 2rem;
}

.cta-content {
    background: linear-gradient(135deg, rgba(139, 92, 246, 0.2) 0%, rgba(236, 72, 153, 0.2) 100%);
    border: 2px solid rgba(139, 92, 246, 0.3);
    border-radius: 2rem;
    padding: 4rem;
    text-align: center;
    backdrop-filter: blur(20px);
}

.cta-title {
    font-size: 3rem;
    font-weight: 800;
    margin-bottom: 1rem;
}

.cta-description {
    font-size: 1.25rem;
    color: rgba(255, 255, 255, 0.7);
    margin-bottom: 2.5rem;
}

.cta-actions {
    display: flex;
    justify-content: center;
    gap: 1rem;
}

/* Footer */
.footer {
    position: relative;
    z-index: 10;
    background: rgba(15, 15, 35, 0.8);
    border-top: 1px solid rgba(139, 92, 246, 0.2);
    padding: 4rem 0 2rem;
}

.footer-container {
    max-width: 1280px;
    margin: 0 auto;
    padding: 0 2rem;
}

.footer-content {
    display: grid;
    grid-template-columns: 2fr 3fr;
    gap: 4rem;
    margin-bottom: 3rem;
}

.footer-brand {
    max-width: 320px;
}

.footer-tagline {
    color: rgba(255, 255, 255, 0.6);
    margin-top: 1rem;
    line-height: 1.6;
}

.footer-links {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 2rem;
}

.footer-column {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.footer-heading {
    font-size: 1rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
}

.footer-link {
    color: rgba(255, 255, 255, 0.6);
    text-decoration: none;
    transition: color 0.3s;
    font-size: 0.875rem;
}

.footer-link:hover {
    color: #8B5CF6;
}

.footer-bottom {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-top: 2rem;
    border-top: 1px solid rgba(139, 92, 246, 0.2);
    color: rgba(255, 255, 255, 0.6);
    font-size: 0.875rem;
}

.footer-social {
    display: flex;
    gap: 1.5rem;
}

.social-link {
    color: rgba(255, 255, 255, 0.6);
    text-decoration: none;
    transition: color 0.3s;
}

.social-link:hover {
    color: #8B5CF6;
}

/* Animations */
@keyframes slideInLeft {
    from {
        opacity: 0;
        transform: translateX(-50px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

@keyframes slideInRight {
    from {
        opacity: 0;
        transform: translateX(50px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

@keyframes fadeIn {
    from {
        opacity: 0;
    }
    to {
        opacity: 1;
    }
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes floatCard {
    0%, 100% {
        transform: translateY(0);
    }
    50% {
        transform: translateY(-20px);
    }
}

@keyframes pulse {
    0%, 100% {
        box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7);
    }
    50% {
        box-shadow: 0 0 0 10px rgba(16, 185, 129, 0);
    }
}

@keyframes growBar {
    0%, 100% {
        transform: scaleY(1);
    }
    50% {
        transform: scaleY(1.2);
    }
}

@keyframes rotate360 {
    from {
        transform: rotate(0deg);
    }
    to {
        transform: rotate(360deg);
    }
}

/* Responsive */
@media (max-width: 1024px) {
    .hero-container {
        grid-template-columns: 1fr;
        gap: 3rem;
    }

    .hero-visual {
        height: 400px;
    }

    .card-1 {
        width: 100%;
        max-width: 380px;
    }

    .card-2 {
        width: 100%;
        max-width: 280px;
    }

    .card-3 {
        width: 100%;
        max-width: 320px;
    }

    .footer-content {
        grid-template-columns: 1fr;
        gap: 2rem;
    }

    .hero-title {
        font-size: 2.5rem;
    }

    .section-title {
        font-size: 2.5rem;
    }

    .cta-title {
        font-size: 2.5rem;
    }
}

@media (max-width: 768px) {
    .nav-container {
        flex-direction: column;
        gap: 1rem;
    }

    .hero-section {
        padding: 3rem 0;
    }

    .hero-title {
        font-size: 2rem;
    }

    .hero-description {
        font-size: 1rem;
    }

    .stats-grid {
        grid-template-columns: repeat(2, 1fr);
    }

    .features-grid {
        grid-template-columns: 1fr;
    }

    .footer-links {
        grid-template-columns: 1fr;
    }

    .footer-bottom {
        flex-direction: column;
        gap: 1rem;
    }

    .section-title {
        font-size: 2rem;
    }

    .cta-title {
        font-size: 2rem;
    }

    .cta-content {
        padding: 2rem;
    }

    .hero-actions {
        flex-direction: column;
    }

    .btn-large {
        width: 100%;
        justify-content: center;
    }

    .hero-visual {
        display: none;
    }
}
</style>