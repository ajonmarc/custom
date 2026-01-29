<script setup lang="ts">
import { Form, Head } from '@inertiajs/vue3';
import InputError from '@/components/InputError.vue';
import TextLink from '@/components/TextLink.vue';
import { Button } from '@/components/ui/button';
import { Checkbox } from '@/components/ui/checkbox';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Spinner } from '@/components/ui/spinner';
import { register } from '@/routes';
import { store } from '@/routes/login';
import { request } from '@/routes/password';
import { ref, onMounted } from 'vue';

defineProps<{
    status?: string;
    canResetPassword: boolean;
    canRegister: boolean;
}>();

// Interactive background elements
const mousePosition = ref({ x: 0, y: 0 });
const particles = ref<Array<{ x: number; y: number; size: number; delay: number }>>([]);

onMounted(() => {
    // Track mouse for interactive gradient
    window.addEventListener('mousemove', (e) => {
        mousePosition.value = {
            x: (e.clientX / window.innerWidth) * 100,
            y: (e.clientY / window.innerHeight) * 100
        };
    });

    // Generate floating particles
    for (let i = 0; i < 20; i++) {
        particles.value.push({
            x: Math.random() * 100,
            y: Math.random() * 100,
            size: Math.random() * 3 + 1,
            delay: Math.random() * 5
        });
    }
});
</script>

<template>
    <Head title="Sign In" />

    <div class="login-page">
        <!-- Animated Background -->
        <div class="background-wrapper">
            <div class="gradient-orb orb-1"></div>
            <div class="gradient-orb orb-2"></div>
            <div class="gradient-orb orb-3"></div>
            
            <!-- Floating particles -->
            <div 
                v-for="(particle, index) in particles" 
                :key="index"
                class="floating-particle"
                :style="{
                    left: `${particle.x}%`,
                    top: `${particle.y}%`,
                    width: `${particle.size}px`,
                    height: `${particle.size}px`,
                    animationDelay: `${particle.delay}s`
                }"
            ></div>

            <!-- Grid pattern overlay -->
            <div class="grid-pattern"></div>
        </div>

        <!-- Main Content -->
        <div class="login-container">
            <!-- Left Panel - Branding -->
            <div class="branding-panel">
                <div class="branding-content">
                    <!-- Logo -->
                    <div class="logo-section">
                        <div class="logo-icon">
                            <svg viewBox="0 0 60 60" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <defs>
                                    <linearGradient id="logoGrad" x1="0" y1="0" x2="60" y2="60">
                                        <stop offset="0%" stop-color="#06b6d4"/>
                                        <stop offset="50%" stop-color="#3b82f6"/>
                                        <stop offset="100%" stop-color="#8b5cf6"/>
                                    </linearGradient>
                                </defs>
                                <circle cx="30" cy="30" r="28" stroke="url(#logoGrad)" stroke-width="4" fill="none"/>
                                <path d="M20 30L27 37L42 22" stroke="url(#logoGrad)" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                        <h1 class="brand-name">VueStarter</h1>
                    </div>

                    <!-- Feature highlights -->
                    <div class="features-list">
                        <div class="feature-item" style="animation-delay: 0.2s">
                            <div class="feature-icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <path d="M9 12L11 14L15 10M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </div>
                            <div class="feature-text">
                                <h3>Secure Authentication</h3>
                                <p>Enterprise-grade security with encryption</p>
                            </div>
                        </div>

                        <div class="feature-item" style="animation-delay: 0.4s">
                            <div class="feature-icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <path d="M13 10V3L4 14H11L11 21L20 10L13 10Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </div>
                            <div class="feature-text">
                                <h3>Lightning Fast</h3>
                                <p>Optimized performance for speed</p>
                            </div>
                        </div>

                        <div class="feature-item" style="animation-delay: 0.6s">
                            <div class="feature-icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <path d="M12 15C13.6569 15 15 13.6569 15 12C15 10.3431 13.6569 9 12 9C10.3431 9 9 10.3431 9 12C9 13.6569 10.3431 15 12 15Z" stroke="currentColor" stroke-width="2"/>
                                    <path d="M19.4 15C19.1277 15.6171 19.2583 16.3378 19.73 16.82L19.79 16.88C20.1656 17.2551 20.3766 17.7642 20.3766 18.295C20.3766 18.8258 20.1656 19.3349 19.79 19.71C19.4149 20.0856 18.9058 20.2966 18.375 20.2966C17.8442 20.2966 17.3351 20.0856 16.96 19.71L16.9 19.65C16.4178 19.1783 15.6971 19.0477 15.08 19.32C14.4755 19.5791 14.0826 20.1724 14.08 20.83V21C14.08 22.1046 13.1846 23 12.08 23C10.9754 23 10.08 22.1046 10.08 21V20.91C10.0642 20.2327 9.63587 19.6339 9 19.4C8.38291 19.1277 7.66219 19.2583 7.18 19.73L7.12 19.79C6.74486 20.1656 6.23582 20.3766 5.705 20.3766C5.17418 20.3766 4.66514 20.1656 4.29 19.79C3.91445 19.4149 3.70343 18.9058 3.70343 18.375C3.70343 17.8442 3.91445 17.3351 4.29 16.96L4.35 16.9C4.82167 16.4178 4.95235 15.6971 4.68 15.08C4.42093 14.4755 3.82764 14.0826 3.17 14.08H3C1.89543 14.08 1 13.1846 1 12.08C1 10.9754 1.89543 10.08 3 10.08H3.09C3.76733 10.0642 4.36613 9.63587 4.6 9C4.87235 8.38291 4.74167 7.66219 4.27 7.18L4.21 7.12C3.83445 6.74486 3.62343 6.23582 3.62343 5.705C3.62343 5.17418 3.83445 4.66514 4.21 4.29C4.58514 3.91445 5.09418 3.70343 5.625 3.70343C6.15582 3.70343 6.66486 3.91445 7.04 4.29L7.1 4.35C7.58219 4.82167 8.30291 4.95235 8.92 4.68H9C9.60447 4.42093 9.99738 3.82764 10 3.17V3C10 1.89543 10.8954 1 12 1C13.1046 1 14 1.89543 14 3V3.09C14.0026 3.74764 14.3955 4.34093 15 4.6C15.6171 4.87235 16.3378 4.74167 16.82 4.27L16.88 4.21C17.2551 3.83445 17.7642 3.62343 18.295 3.62343C18.8258 3.62343 19.3349 3.83445 19.71 4.21C20.0856 4.58514 20.2966 5.09418 20.2966 5.625C20.2966 6.15582 20.0856 6.66486 19.71 7.04L19.65 7.1C19.1783 7.58219 19.0477 8.30291 19.32 8.92V9C19.5791 9.60447 20.1724 9.99738 20.83 10H21C22.1046 10 23 10.8954 23 12C23 13.1046 22.1046 14 21 14H20.91C20.2524 14.0026 19.6591 14.3955 19.4 15Z" stroke="currentColor" stroke-width="2"/>
                                </svg>
                            </div>
                            <div class="feature-text">
                                <h3>Full Control</h3>
                                <p>Customize every aspect of your app</p>
                            </div>
                        </div>
                    </div>

                    <!-- Testimonial -->
                    <div class="testimonial">
                        <div class="quote-mark">"</div>
                        <p class="testimonial-text">
                            This platform has transformed how we build applications. 
                            The developer experience is unmatched.
                        </p>
                        <div class="testimonial-author">
                            <div class="author-avatar">
                                <svg viewBox="0 0 40 40" fill="none">
                                    <circle cx="20" cy="20" r="20" fill="url(#avatarGrad)"/>
                                    <path d="M20 22C23.3137 22 26 19.3137 26 16C26 12.6863 23.3137 10 20 10C16.6863 10 14 12.6863 14 16C14 19.3137 16.6863 22 20 22Z" fill="white"/>
                                    <path d="M10 32C10 27.5817 13.5817 24 18 24H22C26.4183 24 30 27.5817 30 32V34H10V32Z" fill="white"/>
                                    <defs>
                                        <linearGradient id="avatarGrad" x1="0" y1="0" x2="40" y2="40">
                                            <stop offset="0%" stop-color="#06b6d4"/>
                                            <stop offset="100%" stop-color="#8b5cf6"/>
                                        </linearGradient>
                                    </defs>
                                </svg>
                            </div>
                            <div class="author-info">
                                <div class="author-name">Sarah Chen</div>
                                <div class="author-role">Lead Developer, TechCorp</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Decorative elements -->
                <div class="deco-circle circle-1"></div>
                <div class="deco-circle circle-2"></div>
            </div>

            <!-- Right Panel - Login Form -->
            <div class="form-panel">
                <div class="form-container">
                    <!-- Header -->
                    <div class="form-header">
                        <h2 class="form-title">Welcome Back</h2>
                        <p class="form-subtitle">Sign in to continue to your account</p>
                    </div>

                    <!-- Status Message -->
                    <div v-if="status" class="status-message">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                            <path d="M6 10L8.5 12.5L14 7M19 10C19 14.9706 14.9706 19 10 19C5.02944 19 1 14.9706 1 10C1 5.02944 5.02944 1 10 1C14.9706 1 19 5.02944 19 10Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <span>{{ status }}</span>
                    </div>

                    <!-- Login Form -->
                    <Form
                        v-bind="store.form()"
                        :reset-on-success="['password']"
                        v-slot="{ errors, processing }"
                        class="login-form"
                    >
                        <!-- Email Field -->
                        <div class="form-group">
                            <Label for="email" class="form-label">
                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                                    <path d="M2.66667 2.66666H13.3333C14.0667 2.66666 14.6667 3.26666 14.6667 4V12C14.6667 12.7333 14.0667 13.3333 13.3333 13.3333H2.66667C1.93333 13.3333 1.33333 12.7333 1.33333 12V4C1.33333 3.26666 1.93333 2.66666 2.66667 2.66666Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M14.6667 4L8 8.66667L1.33333 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                Email Address
                            </Label>
                            <div class="input-wrapper">
                                <Input
                                    id="email"
                                    type="email"
                                    name="email"
                                    autofocus
                                    :tabindex="1"
                                    autocomplete="email"
                                    placeholder="Enter your email"
                                    class="custom-input"
                                />
                            </div>
                            <InputError :message="errors.email" class="error-message" />
                        </div>

                        <!-- Password Field -->
                        <div class="form-group">
                            <div class="label-row">
                                <Label for="password" class="form-label">
                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                                        <path d="M12.6667 7.33333H3.33333C2.59695 7.33333 2 7.93029 2 8.66667V13.3333C2 14.0697 2.59695 14.6667 3.33333 14.6667H12.6667C13.403 14.6667 14 14.0697 14 13.3333V8.66667C14 7.93029 13.403 7.33333 12.6667 7.33333Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M4.66667 7.33333V4.66667C4.66667 3.78261 5.01786 2.93477 5.64298 2.30964C6.2681 1.68452 7.11595 1.33333 8 1.33333C8.88406 1.33333 9.7319 1.68452 10.357 2.30964C10.9821 2.93477 11.3333 3.78261 11.3333 4.66667V7.33333" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    Password
                                </Label>
                                <TextLink
                                    v-if="canResetPassword"
                                    :href="request()"
                                    class="forgot-link"
                                    :tabindex="5"
                                >
                                    Forgot?
                                </TextLink>
                            </div>
                            <div class="input-wrapper">
                                <Input
                                    id="password"
                                    type="password"
                                    name="password"
                                    :tabindex="2"
                                    autocomplete="current-password"
                                    placeholder="Enter your password"
                                    class="custom-input"
                                />
                            </div>
                            <InputError :message="errors.password" class="error-message" />
                        </div>

                        <!-- Remember Me -->
                        <div class="remember-row">
                            <Label for="remember" class="remember-label">
                                <Checkbox id="remember" name="remember" :tabindex="3" />
                                <span>Keep me signed in</span>
                            </Label>
                        </div>

                        <!-- Submit Button -->
                        <Button
                            type="submit"
                            class="submit-button"
                            :tabindex="4"
                            :disabled="processing"
                            data-test="login-button"
                        >
                            <Spinner v-if="processing" class="button-spinner" />
                            <span v-if="!processing">Sign In</span>
                            <span v-else>Signing In...</span>
                            <svg v-if="!processing" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                <path d="M7 4L13 10L7 16" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </Button>

                        <!-- Divider -->
                        <div class="divider">
                            <span>or continue with</span>
                        </div>

                        <!-- Social Login -->
                        <div class="social-buttons">
                            <button type="button" class="social-btn">
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                                    <path d="M18.1716 8.36788H17.5V8.33329H10V11.6666H14.7097C14.0225 13.6069 12.1763 15 10 15C7.23875 15 5 12.7612 5 9.99996C5 7.23871 7.23875 4.99996 10 4.99996C11.2747 4.99996 12.4342 5.48079 13.3172 6.26621L15.6741 3.90933C14.1859 2.52204 12.1953 1.66663 10 1.66663C5.39792 1.66663 1.66667 5.39788 1.66667 9.99996C1.66667 14.602 5.39792 18.3333 10 18.3333C14.6021 18.3333 18.3333 14.602 18.3333 9.99996C18.3333 9.44121 18.2758 8.89579 18.1716 8.36788Z" fill="#FFC107"/>
                                    <path d="M2.6275 6.12121L5.36542 8.12913C6.10625 6.29496 7.90042 4.99996 10 4.99996C11.2746 4.99996 12.4342 5.48079 13.3171 6.26621L15.6742 3.90933C14.1858 2.52204 12.1954 1.66663 10 1.66663C6.79917 1.66663 4.02333 3.47371 2.6275 6.12121Z" fill="#FF3D00"/>
                                    <path d="M10 18.3334C12.1525 18.3334 14.1083 17.5096 15.5871 16.17L13.0079 13.9875C12.1431 14.6452 11.0864 15.0009 10 15C7.83249 15 5.99207 13.6179 5.29874 11.6892L2.58124 13.7829C3.96041 16.4817 6.76124 18.3334 10 18.3334Z" fill="#4CAF50"/>
                                    <path d="M18.1716 8.36796H17.5V8.33337H10V11.6667H14.7096C14.3809 12.5902 13.7889 13.3972 13.0067 13.9879L13.0079 13.9871L15.5871 16.1696C15.4046 16.3363 18.3333 14.1667 18.3333 10C18.3333 9.44129 18.2758 8.89587 18.1716 8.36796Z" fill="#1976D2"/>
                                </svg>
                                <span>Google</span>
                            </button>
                            <button type="button" class="social-btn">
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                                    <path d="M10 0C4.477 0 0 4.477 0 10C0 14.991 3.657 19.128 8.438 19.878V12.891H5.898V10H8.438V7.797C8.438 5.291 9.93 3.907 12.215 3.907C13.309 3.907 14.453 4.102 14.453 4.102V6.562H13.193C11.95 6.562 11.563 7.333 11.563 8.124V10H14.336L13.893 12.89H11.563V19.878C16.343 19.128 20 14.991 20 10C20 4.477 15.523 0 10 0Z" fill="#1877F2"/>
                                </svg>
                                <span>Facebook</span>
                            </button>
                        </div>

                        <!-- Sign Up Link -->
                        <div class="signup-prompt" v-if="canRegister">
                            <span>Don't have an account?</span>
                            <TextLink :href="register()" :tabindex="5" class="signup-link">
                                Create Account
                            </TextLink>
                        </div>
                    </Form>
                </div>

                <!-- Footer -->
                <div class="form-footer">
                    <div class="footer-links">
                        <a href="#" class="footer-link">Privacy Policy</a>
                        <span class="footer-separator">•</span>
                        <a href="#" class="footer-link">Terms of Service</a>
                        <span class="footer-separator">•</span>
                        <a href="#" class="footer-link">Help Center</a>
                    </div>
                    <p class="copyright">© 2026 VueStarter. All rights reserved.</p>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500&display=swap');

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

.login-page {
    font-family: 'Outfit', sans-serif;
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #0a0e27;
    position: relative;
    overflow: hidden;
}

/* Background Animation */
.background-wrapper {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    pointer-events: none;
    z-index: 0;
}

.gradient-orb {
    position: absolute;
    border-radius: 50%;
    filter: blur(80px);
    opacity: 0.3;
    animation: float 20s ease-in-out infinite;
}

.orb-1 {
    width: 600px;
    height: 600px;
    background: radial-gradient(circle, #06b6d4 0%, transparent 70%);
    top: -200px;
    left: -200px;
    animation-delay: 0s;
}

.orb-2 {
    width: 500px;
    height: 500px;
    background: radial-gradient(circle, #8b5cf6 0%, transparent 70%);
    bottom: -150px;
    right: -150px;
    animation-delay: -7s;
}

.orb-3 {
    width: 400px;
    height: 400px;
    background: radial-gradient(circle, #3b82f6 0%, transparent 70%);
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    animation-delay: -14s;
}

.floating-particle {
    position: absolute;
    background: radial-gradient(circle, rgba(59, 130, 246, 0.5) 0%, transparent 70%);
    border-radius: 50%;
    animation: particleFloat 15s ease-in-out infinite;
}

.grid-pattern {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-image: 
        linear-gradient(rgba(59, 130, 246, 0.05) 1px, transparent 1px),
        linear-gradient(90deg, rgba(59, 130, 246, 0.05) 1px, transparent 1px);
    background-size: 50px 50px;
    mask-image: radial-gradient(ellipse at center, black 0%, transparent 80%);
}

/* Main Container */
.login-container {
    position: relative;
    z-index: 10;
    display: grid;
    grid-template-columns: 1fr 1fr;
    max-width: 1400px;
    width: 95%;
    background: rgba(15, 23, 42, 0.6);
    backdrop-filter: blur(40px);
    border-radius: 2rem;
    overflow: hidden;
    box-shadow: 
        0 0 0 1px rgba(59, 130, 246, 0.1),
        0 20px 60px rgba(0, 0, 0, 0.4),
        0 0 100px rgba(59, 130, 246, 0.1);
    min-height: 700px;
    animation: slideUp 0.8s ease-out;
}

/* Branding Panel */
.branding-panel {
    background: linear-gradient(135deg, rgba(6, 182, 212, 0.1) 0%, rgba(59, 130, 246, 0.1) 50%, rgba(139, 92, 246, 0.1) 100%);
    padding: 4rem;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    position: relative;
    overflow: hidden;
    border-right: 1px solid rgba(59, 130, 246, 0.1);
}

.branding-content {
    position: relative;
    z-index: 2;
}

.logo-section {
    margin-bottom: 4rem;
    animation: fadeIn 0.8s ease-out 0.2s backwards;
}

.logo-icon {
    width: 60px;
    height: 60px;
    margin-bottom: 1.5rem;
}

.brand-name {
    font-size: 2.5rem;
    font-weight: 800;
    background: linear-gradient(135deg, #06b6d4 0%, #3b82f6 50%, #8b5cf6 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    letter-spacing: -0.02em;
}

.features-list {
    display: flex;
    flex-direction: column;
    gap: 2rem;
    margin-bottom: 3rem;
}

.feature-item {
    display: flex;
    gap: 1.25rem;
    animation: slideInLeft 0.8s ease-out backwards;
}

.feature-icon {
    width: 48px;
    height: 48px;
    background: rgba(59, 130, 246, 0.1);
    border: 1px solid rgba(59, 130, 246, 0.2);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #60a5fa;
    flex-shrink: 0;
}

.feature-text h3 {
    color: #f1f5f9;
    font-size: 1.125rem;
    font-weight: 600;
    margin-bottom: 0.25rem;
}

.feature-text p {
    color: #94a3b8;
    font-size: 0.875rem;
    line-height: 1.5;
}

.testimonial {
    background: rgba(255, 255, 255, 0.03);
    border: 1px solid rgba(59, 130, 246, 0.1);
    border-radius: 1.5rem;
    padding: 2rem;
    position: relative;
    animation: fadeIn 0.8s ease-out 0.8s backwards;
}

.quote-mark {
    position: absolute;
    top: -0.5rem;
    left: 1.5rem;
    font-size: 4rem;
    font-weight: 700;
    background: linear-gradient(135deg, #06b6d4 0%, #3b82f6 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    opacity: 0.3;
    line-height: 1;
}

.testimonial-text {
    color: #cbd5e1;
    font-size: 1rem;
    line-height: 1.6;
    margin-bottom: 1.5rem;
    font-style: italic;
}

.testimonial-author {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.author-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    overflow: hidden;
}

.author-name {
    color: #f1f5f9;
    font-weight: 600;
    font-size: 0.875rem;
}

.author-role {
    color: #64748b;
    font-size: 0.75rem;
}

.deco-circle {
    position: absolute;
    border-radius: 50%;
    border: 2px solid rgba(59, 130, 246, 0.1);
}

.circle-1 {
    width: 300px;
    height: 300px;
    top: -100px;
    right: -100px;
    animation: rotate 30s linear infinite;
}

.circle-2 {
    width: 200px;
    height: 200px;
    bottom: -50px;
    left: -50px;
    animation: rotate 25s linear infinite reverse;
}

/* Form Panel */
.form-panel {
    padding: 4rem;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    background: rgba(15, 23, 42, 0.4);
}

.form-container {
    flex: 1;
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.form-header {
    margin-bottom: 2.5rem;
    animation: fadeIn 0.8s ease-out 0.3s backwards;
}

.form-title {
    font-size: 2.5rem;
    font-weight: 800;
    color: #f1f5f9;
    margin-bottom: 0.5rem;
    letter-spacing: -0.02em;
}

.form-subtitle {
    color: #94a3b8;
    font-size: 1rem;
}

.status-message {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 1rem 1.25rem;
    background: rgba(16, 185, 129, 0.1);
    border: 1px solid rgba(16, 185, 129, 0.3);
    border-radius: 0.75rem;
    color: #34d399;
    margin-bottom: 2rem;
    animation: slideDown 0.5s ease-out;
}

.login-form {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.form-group {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
    animation: fadeInUp 0.6s ease-out backwards;
}

.form-group:nth-child(1) {
    animation-delay: 0.4s;
}

.form-group:nth-child(2) {
    animation-delay: 0.5s;
}

.form-label {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: #cbd5e1;
    font-weight: 500;
    font-size: 0.875rem;
}

.form-label svg {
    stroke: #64748b;
}

.label-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.forgot-link {
    color: #60a5fa;
    font-size: 0.875rem;
    font-weight: 500;
    text-decoration: none;
    transition: color 0.3s;
}

.forgot-link:hover {
    color: #3b82f6;
}

.input-wrapper {
    position: relative;
}

.custom-input {
    width: 100%;
    padding: 0.875rem 1rem;
    background: rgba(30, 41, 59, 0.5);
    border: 1.5px solid rgba(59, 130, 246, 0.2);
    border-radius: 0.75rem;
    color: #f1f5f9;
    font-size: 0.9375rem;
    transition: all 0.3s;
    outline: none;
}

.custom-input::placeholder {
    color: #64748b;
}

.custom-input:focus {
    background: rgba(30, 41, 59, 0.7);
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

.error-message {
    color: #f87171;
    font-size: 0.8125rem;
}

.remember-row {
    animation: fadeInUp 0.6s ease-out 0.6s backwards;
}

.remember-label {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    color: #cbd5e1;
    font-size: 0.875rem;
    font-weight: 500;
    cursor: pointer;
}

.submit-button {
    width: 100%;
    padding: 1rem 1.5rem;
    background: linear-gradient(135deg, #06b6d4 0%, #3b82f6 50%, #8b5cf6 100%);
    color: white;
    font-weight: 600;
    font-size: 1rem;
    border-radius: 0.75rem;
    border: none;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    transition: all 0.3s;
    box-shadow: 0 4px 20px rgba(59, 130, 246, 0.3);
    animation: fadeInUp 0.6s ease-out 0.7s backwards;
}

.submit-button:hover:not(:disabled) {
    transform: translateY(-2px);
    box-shadow: 0 8px 30px rgba(59, 130, 246, 0.4);
}

.submit-button:disabled {
    opacity: 0.6;
    cursor: not-allowed;
}

.button-spinner {
    width: 20px;
    height: 20px;
}

.divider {
    position: relative;
    text-align: center;
    margin: 1.5rem 0;
    animation: fadeIn 0.6s ease-out 0.8s backwards;
}

.divider::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 0;
    right: 0;
    height: 1px;
    background: rgba(59, 130, 246, 0.2);
}

.divider span {
    position: relative;
    background: rgba(15, 23, 42, 0.9);
    padding: 0 1rem;
    color: #64748b;
    font-size: 0.875rem;
}

.social-buttons {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
    animation: fadeInUp 0.6s ease-out 0.9s backwards;
}

.social-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.75rem;
    padding: 0.875rem 1rem;
    background: rgba(30, 41, 59, 0.5);
    border: 1.5px solid rgba(59, 130, 246, 0.2);
    border-radius: 0.75rem;
    color: #cbd5e1;
    font-weight: 500;
    font-size: 0.875rem;
    cursor: pointer;
    transition: all 0.3s;
}

.social-btn:hover {
    background: rgba(30, 41, 59, 0.7);
    border-color: rgba(59, 130, 246, 0.4);
    transform: translateY(-2px);
}

.signup-prompt {
    text-align: center;
    color: #94a3b8;
    font-size: 0.875rem;
    animation: fadeIn 0.6s ease-out 1s backwards;
}

.signup-link {
    color: #60a5fa;
    font-weight: 600;
    text-decoration: none;
    margin-left: 0.25rem;
    transition: color 0.3s;
}

.signup-link:hover {
    color: #3b82f6;
}

.form-footer {
    margin-top: 3rem;
    padding-top: 2rem;
    border-top: 1px solid rgba(59, 130, 246, 0.1);
    text-align: center;
}

.footer-links {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 1rem;
    margin-bottom: 1rem;
}

.footer-link {
    color: #64748b;
    text-decoration: none;
    font-size: 0.8125rem;
    transition: color 0.3s;
}

.footer-link:hover {
    color: #60a5fa;
}

.footer-separator {
    color: #334155;
}

.copyright {
    color: #475569;
    font-size: 0.8125rem;
}

/* Animations */
@keyframes float {
    0%, 100% {
        transform: translate(0, 0);
    }
    33% {
        transform: translate(30px, -30px);
    }
    66% {
        transform: translate(-20px, 20px);
    }
}

@keyframes particleFloat {
    0%, 100% {
        transform: translateY(0) translateX(0);
        opacity: 0.3;
    }
    50% {
        transform: translateY(-100px) translateX(50px);
        opacity: 0.6;
    }
}

@keyframes rotate {
    from {
        transform: rotate(0deg);
    }
    to {
        transform: rotate(360deg);
    }
}

@keyframes slideUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
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
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes slideInLeft {
    from {
        opacity: 0;
        transform: translateX(-30px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Responsive */
@media (max-width: 1024px) {
    .login-container {
        grid-template-columns: 1fr;
        max-width: 500px;
    }

    .branding-panel {
        display: none;
    }

    .form-panel {
        padding: 3rem 2rem;
    }
}

@media (max-width: 640px) {
    .form-panel {
        padding: 2rem 1.5rem;
    }

    .form-title {
        font-size: 2rem;
    }

    .social-buttons {
        grid-template-columns: 1fr;
    }
}
</style>