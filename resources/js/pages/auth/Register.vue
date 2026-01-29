<script setup lang="ts">
import { Form, Head } from '@inertiajs/vue3';
import InputError from '@/components/InputError.vue';
import TextLink from '@/components/TextLink.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Spinner } from '@/components/ui/spinner';
import { login } from '@/routes';
import { store } from '@/routes/register';
import { ref, onMounted } from 'vue';

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
    <Head title="Create Account" />

    <div class="register-page">
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
        <div class="register-container">
            <!-- Left Panel - Registration Form -->
            <div class="form-panel">
                <div class="form-container">
                    <!-- Header -->
                    <div class="form-header">
                        <!-- Logo -->
                        <div class="logo-section">
                            <div class="logo-icon">
                                <svg viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <defs>
                                        <linearGradient id="logoGrad" x1="0" y1="0" x2="50" y2="50">
                                            <stop offset="0%" stop-color="#06b6d4"/>
                                            <stop offset="50%" stop-color="#3b82f6"/>
                                            <stop offset="100%" stop-color="#8b5cf6"/>
                                        </linearGradient>
                                    </defs>
                                    <circle cx="25" cy="25" r="23" stroke="url(#logoGrad)" stroke-width="4" fill="none"/>
                                    <path d="M17 25L22 30L35 18" stroke="url(#logoGrad)" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </div>
                            <span class="brand-name">VueStarter</span>
                        </div>

                        <h2 class="form-title">Create Your Account</h2>
                        <p class="form-subtitle">Join thousands of developers building amazing applications</p>
                    </div>

                    <!-- Registration Form -->
                    <Form
                        v-bind="store.form()"
                        :reset-on-success="['password', 'password_confirmation']"
                        v-slot="{ errors, processing }"
                        class="register-form"
                    >
                        <!-- Name Field -->
                        <div class="form-group">
                            <Label for="name" class="form-label">
                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                                    <path d="M8 8C10.2091 8 12 6.20914 12 4C12 1.79086 10.2091 0 8 0C5.79086 0 4 1.79086 4 4C4 6.20914 5.79086 8 8 8Z" stroke="currentColor" stroke-width="1.5"/>
                                    <path d="M2 16C2 13.7909 3.79086 12 6 12H10C12.2091 12 14 13.7909 14 16V16H2V16Z" stroke="currentColor" stroke-width="1.5"/>
                                </svg>
                                Full Name
                            </Label>
                            <div class="input-wrapper">
                                <Input
                                    id="name"
                                    type="text"
                                    name="name"
                                    autofocus
                                    :tabindex="1"
                                    autocomplete="name"
                                    placeholder="Enter your full name"
                                    class="custom-input"
                                />
                            </div>
                            <InputError :message="errors.name" class="error-message" />
                        </div>

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
                                    :tabindex="2"
                                    autocomplete="email"
                                    placeholder="Enter your email"
                                    class="custom-input"
                                />
                            </div>
                            <InputError :message="errors.email" class="error-message" />
                        </div>

                        <!-- Password Field -->
                        <div class="form-group">
                            <Label for="password" class="form-label">
                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                                    <path d="M12.6667 7.33333H3.33333C2.59695 7.33333 2 7.93029 2 8.66667V13.3333C2 14.0697 2.59695 14.6667 3.33333 14.6667H12.6667C13.403 14.6667 14 14.0697 14 13.3333V8.66667C14 7.93029 13.403 7.33333 12.6667 7.33333Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M4.66667 7.33333V4.66667C4.66667 3.78261 5.01786 2.93477 5.64298 2.30964C6.2681 1.68452 7.11595 1.33333 8 1.33333C8.88406 1.33333 9.7319 1.68452 10.357 2.30964C10.9821 2.93477 11.3333 3.78261 11.3333 4.66667V7.33333" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                Password
                            </Label>
                            <div class="input-wrapper">
                                <Input
                                    id="password"
                                    type="password"
                                    name="password"
                                    :tabindex="3"
                                    autocomplete="new-password"
                                    placeholder="Create a strong password"
                                    class="custom-input"
                                />
                            </div>
                            <InputError :message="errors.password" class="error-message" />
                        </div>

                        <!-- Confirm Password Field -->
                        <div class="form-group">
                            <Label for="password_confirmation" class="form-label">
                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                                    <path d="M8 14.6667C11.6819 14.6667 14.6667 11.6819 14.6667 8C14.6667 4.3181 11.6819 1.33333 8 1.33333C4.3181 1.33333 1.33333 4.3181 1.33333 8C1.33333 11.6819 4.3181 14.6667 8 14.6667Z" stroke="currentColor" stroke-width="1.5"/>
                                    <path d="M5.33333 8L7.33333 10L10.6667 6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                Confirm Password
                            </Label>
                            <div class="input-wrapper">
                                <Input
                                    id="password_confirmation"
                                    type="password"
                                    name="password_confirmation"
                                    :tabindex="4"
                                    autocomplete="new-password"
                                    placeholder="Re-enter your password"
                                    class="custom-input"
                                />
                            </div>
                            <InputError :message="errors.password_confirmation" class="error-message" />
                        </div>

                        <!-- Password Requirements -->
                        <div class="password-requirements">
                            <div class="requirement-title">Password must contain:</div>
                            <div class="requirements-list">
                                <div class="requirement-item">
                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                                        <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-width="1.5"/>
                                        <path d="M5 8L7 10L11 6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    <span>At least 8 characters</span>
                                </div>
                                <div class="requirement-item">
                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                                        <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-width="1.5"/>
                                        <path d="M5 8L7 10L11 6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    <span>One uppercase letter</span>
                                </div>
                                <div class="requirement-item">
                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                                        <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-width="1.5"/>
                                        <path d="M5 8L7 10L11 6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    <span>One number or symbol</span>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <Button
                            type="submit"
                            class="submit-button"
                            :tabindex="5"
                            :disabled="processing"
                            data-test="register-user-button"
                        >
                            <Spinner v-if="processing" class="button-spinner" />
                            <span v-if="!processing">Create Account</span>
                            <span v-else>Creating Account...</span>
                            <svg v-if="!processing" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                <path d="M7 4L13 10L7 16" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </Button>

                        <!-- Divider -->
                        <div class="divider">
                            <span>or sign up with</span>
                        </div>

                        <!-- Social Signup -->
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
                                    <path d="M20 10C20 4.477 15.523 0 10 0C4.477 0 0 4.477 0 10C0 14.991 3.657 19.128 8.438 19.878V12.891H5.898V10H8.438V7.797C8.438 5.291 9.93 3.907 12.215 3.907C13.309 3.907 14.453 4.102 14.453 4.102V6.562H13.193C11.95 6.562 11.563 7.333 11.563 8.124V10H14.336L13.893 12.89H11.563V19.878C16.343 19.128 20 14.991 20 10Z" fill="#1877F2"/>
                                </svg>
                                <span>Facebook</span>
                            </button>
                        </div>

                        <!-- Login Link -->
                        <div class="login-prompt">
                            <span>Already have an account?</span>
                            <TextLink :href="login()" :tabindex="6" class="login-link">
                                Sign In
                            </TextLink>
                        </div>
                    </Form>
                </div>

                <!-- Footer -->
                <div class="form-footer">
                    <p class="terms-text">
                        By creating an account, you agree to our
                        <a href="#" class="terms-link">Terms of Service</a>
                        and
                        <a href="#" class="terms-link">Privacy Policy</a>
                    </p>
                </div>
            </div>

            <!-- Right Panel - Benefits -->
            <div class="benefits-panel">
                <div class="benefits-content">
                    <div class="benefits-header">
                        <h3 class="benefits-title">Why Join VueStarter?</h3>
                        <p class="benefits-subtitle">Everything you need to build amazing applications</p>
                    </div>

                    <div class="benefits-list">
                        <div class="benefit-card" style="animation-delay: 0.2s">
                            <div class="benefit-icon">
                                <svg width="32" height="32" viewBox="0 0 32 32" fill="none">
                                    <circle cx="16" cy="16" r="14" stroke="url(#grad1)" stroke-width="2"/>
                                    <path d="M10 16L14 20L22 11" stroke="url(#grad1)" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    <defs>
                                        <linearGradient id="grad1" x1="0" y1="0" x2="32" y2="32">
                                            <stop offset="0%" stop-color="#06b6d4"/>
                                            <stop offset="100%" stop-color="#3b82f6"/>
                                        </linearGradient>
                                    </defs>
                                </svg>
                            </div>
                            <div class="benefit-content">
                                <h4 class="benefit-title">Production Ready</h4>
                                <p class="benefit-description">Deploy enterprise-grade applications with confidence using battle-tested tools and best practices</p>
                            </div>
                        </div>

                        <div class="benefit-card" style="animation-delay: 0.4s">
                            <div class="benefit-icon">
                                <svg width="32" height="32" viewBox="0 0 32 32" fill="none">
                                    <path d="M16 4V8M16 24V28M8 16H4M28 16H24M23.314 8.686L20.485 11.515M11.515 20.485L8.686 23.314M23.314 23.314L20.485 20.485M11.515 11.515L8.686 8.686" stroke="url(#grad2)" stroke-width="2.5" stroke-linecap="round"/>
                                    <circle cx="16" cy="16" r="4" stroke="url(#grad2)" stroke-width="2.5"/>
                                    <defs>
                                        <linearGradient id="grad2" x1="0" y1="0" x2="32" y2="32">
                                            <stop offset="0%" stop-color="#3b82f6"/>
                                            <stop offset="100%" stop-color="#8b5cf6"/>
                                        </linearGradient>
                                    </defs>
                                </svg>
                            </div>
                            <div class="benefit-content">
                                <h4 class="benefit-title">Full Customization</h4>
                                <p class="benefit-description">Complete control over your application with flexible architecture and unlimited customization options</p>
                            </div>
                        </div>

                        <div class="benefit-card" style="animation-delay: 0.6s">
                            <div class="benefit-icon">
                                <svg width="32" height="32" viewBox="0 0 32 32" fill="none">
                                    <path d="M26 8L16 2L6 8M26 8L16 14M26 8V24L16 30M16 14L6 8M16 14V30M6 8V24L16 30" stroke="url(#grad3)" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    <defs>
                                        <linearGradient id="grad3" x1="0" y1="0" x2="32" y2="32">
                                            <stop offset="0%" stop-color="#8b5cf6"/>
                                            <stop offset="100%" stop-color="#ec4899"/>
                                        </linearGradient>
                                    </defs>
                                </svg>
                            </div>
                            <div class="benefit-content">
                                <h4 class="benefit-title">Modern Stack</h4>
                                <p class="benefit-description">Built with Vue 3, Laravel, TypeScript, and Inertia for the best developer experience possible</p>
                            </div>
                        </div>

                        <div class="benefit-card" style="animation-delay: 0.8s">
                            <div class="benefit-icon">
                                <svg width="32" height="32" viewBox="0 0 32 32" fill="none">
                                    <path d="M16 28C22.6274 28 28 22.6274 28 16C28 9.37258 22.6274 4 16 4C9.37258 4 4 9.37258 4 16C4 22.6274 9.37258 28 16 28Z" stroke="url(#grad4)" stroke-width="2.5"/>
                                    <path d="M4 16H28M16 4C18.5 7.5 19.5 11.5 19.5 16C19.5 20.5 18.5 24.5 16 28M16 4C13.5 7.5 12.5 11.5 12.5 16C12.5 20.5 13.5 24.5 16 28" stroke="url(#grad4)" stroke-width="2.5"/>
                                    <defs>
                                        <linearGradient id="grad4" x1="0" y1="0" x2="32" y2="32">
                                            <stop offset="0%" stop-color="#06b6d4"/>
                                            <stop offset="100%" stop-color="#8b5cf6"/>
                                        </linearGradient>
                                    </defs>
                                </svg>
                            </div>
                            <div class="benefit-content">
                                <h4 class="benefit-title">Global Scale</h4>
                                <p class="benefit-description">Built to scale globally with optimized performance, CDN support, and worldwide infrastructure</p>
                            </div>
                        </div>
                    </div>

                    <!-- Stats -->
                    <div class="stats-section">
                        <div class="stat-item">
                            <div class="stat-value">10K+</div>
                            <div class="stat-label">Active Users</div>
                        </div>
                        <div class="stat-divider"></div>
                        <div class="stat-item">
                            <div class="stat-value">99.9%</div>
                            <div class="stat-label">Uptime SLA</div>
                        </div>
                        <div class="stat-divider"></div>
                        <div class="stat-item">
                            <div class="stat-value">24/7</div>
                            <div class="stat-label">Support</div>
                        </div>
                    </div>
                </div>

                <!-- Decorative elements -->
                <div class="deco-square square-1"></div>
                <div class="deco-square square-2"></div>
                <div class="deco-circle circle-1"></div>
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

.register-page {
    font-family: 'Outfit', sans-serif;
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #0a0e27;
    position: relative;
    overflow: hidden;
    padding: 2rem 0;
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
    right: -200px;
    animation-delay: 0s;
}

.orb-2 {
    width: 500px;
    height: 500px;
    background: radial-gradient(circle, #8b5cf6 0%, transparent 70%);
    bottom: -150px;
    left: -150px;
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
.register-container {
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
    min-height: 800px;
    animation: slideUp 0.8s ease-out;
}

/* Form Panel */
.form-panel {
    padding: 3rem;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    background: rgba(15, 23, 42, 0.4);
    border-right: 1px solid rgba(59, 130, 246, 0.1);
}

.form-container {
    flex: 1;
}

.form-header {
    margin-bottom: 2.5rem;
}

.logo-section {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin-bottom: 2rem;
    animation: fadeIn 0.8s ease-out 0.2s backwards;
}

.logo-icon {
    width: 50px;
    height: 50px;
}

.brand-name {
    font-size: 1.75rem;
    font-weight: 800;
    background: linear-gradient(135deg, #06b6d4 0%, #3b82f6 50%, #8b5cf6 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    letter-spacing: -0.02em;
}

.form-title {
    font-size: 2rem;
    font-weight: 800;
    color: #f1f5f9;
    margin-bottom: 0.5rem;
    letter-spacing: -0.02em;
    animation: fadeIn 0.8s ease-out 0.3s backwards;
}

.form-subtitle {
    color: #94a3b8;
    font-size: 0.9375rem;
    animation: fadeIn 0.8s ease-out 0.4s backwards;
}

.register-form {
    display: flex;
    flex-direction: column;
    gap: 1.25rem;
}

.form-group {
    display: flex;
    flex-direction: column;
    gap: 0.625rem;
    animation: fadeInUp 0.6s ease-out backwards;
}

.form-group:nth-child(1) {
    animation-delay: 0.5s;
}

.form-group:nth-child(2) {
    animation-delay: 0.6s;
}

.form-group:nth-child(3) {
    animation-delay: 0.7s;
}

.form-group:nth-child(4) {
    animation-delay: 0.8s;
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

.input-wrapper {
    position: relative;
}

.custom-input {
    width: 100%;
    padding: 0.75rem 1rem;
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

.password-requirements {
    background: rgba(59, 130, 246, 0.05);
    border: 1px solid rgba(59, 130, 246, 0.1);
    border-radius: 0.75rem;
    padding: 1rem;
    animation: fadeInUp 0.6s ease-out 0.9s backwards;
}

.requirement-title {
    color: #cbd5e1;
    font-size: 0.8125rem;
    font-weight: 600;
    margin-bottom: 0.75rem;
}

.requirements-list {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.requirement-item {
    display: flex;
    align-items: center;
    gap: 0.625rem;
    color: #94a3b8;
    font-size: 0.8125rem;
}

.requirement-item svg {
    stroke: #3b82f6;
    flex-shrink: 0;
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
    animation: fadeInUp 0.6s ease-out 1s backwards;
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
    margin: 1.25rem 0;
    animation: fadeIn 0.6s ease-out 1.1s backwards;
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
    animation: fadeInUp 0.6s ease-out 1.2s backwards;
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

.login-prompt {
    text-align: center;
    color: #94a3b8;
    font-size: 0.875rem;
    animation: fadeIn 0.6s ease-out 1.3s backwards;
}

.login-link {
    color: #60a5fa;
    font-weight: 600;
    text-decoration: none;
    margin-left: 0.25rem;
    transition: color 0.3s;
}

.login-link:hover {
    color: #3b82f6;
}

.form-footer {
    margin-top: 2rem;
    padding-top: 1.5rem;
    border-top: 1px solid rgba(59, 130, 246, 0.1);
}

.terms-text {
    color: #64748b;
    font-size: 0.8125rem;
    text-align: center;
    line-height: 1.5;
}

.terms-link {
    color: #60a5fa;
    text-decoration: none;
    transition: color 0.3s;
}

.terms-link:hover {
    color: #3b82f6;
}

/* Benefits Panel */
.benefits-panel {
    background: linear-gradient(135deg, rgba(6, 182, 212, 0.1) 0%, rgba(59, 130, 246, 0.1) 50%, rgba(139, 92, 246, 0.1) 100%);
    padding: 3rem;
    position: relative;
    overflow: hidden;
}

.benefits-content {
    position: relative;
    z-index: 2;
    height: 100%;
    display: flex;
    flex-direction: column;
}

.benefits-header {
    margin-bottom: 3rem;
    animation: fadeIn 0.8s ease-out 0.4s backwards;
}

.benefits-title {
    font-size: 2rem;
    font-weight: 800;
    color: #f1f5f9;
    margin-bottom: 0.75rem;
    letter-spacing: -0.02em;
}

.benefits-subtitle {
    color: #94a3b8;
    font-size: 1rem;
}

.benefits-list {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
    margin-bottom: 3rem;
    flex: 1;
}

.benefit-card {
    background: rgba(255, 255, 255, 0.03);
    border: 1px solid rgba(59, 130, 246, 0.15);
    border-radius: 1.25rem;
    padding: 1.5rem;
    transition: all 0.3s;
    animation: slideInRight 0.8s ease-out backwards;
}

.benefit-card:hover {
    background: rgba(255, 255, 255, 0.05);
    border-color: rgba(59, 130, 246, 0.3);
    transform: translateX(-8px);
}

.benefit-icon {
    width: 56px;
    height: 56px;
    background: rgba(59, 130, 246, 0.1);
    border: 1px solid rgba(59, 130, 246, 0.2);
    border-radius: 1rem;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 1.25rem;
}

.benefit-title {
    color: #f1f5f9;
    font-size: 1.125rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
}

.benefit-description {
    color: #94a3b8;
    font-size: 0.875rem;
    line-height: 1.6;
}

.stats-section {
    display: flex;
    align-items: center;
    justify-content: space-around;
    background: rgba(255, 255, 255, 0.03);
    border: 1px solid rgba(59, 130, 246, 0.1);
    border-radius: 1.25rem;
    padding: 2rem;
    animation: fadeIn 0.8s ease-out 1.2s backwards;
}

.stat-item {
    text-align: center;
}

.stat-value {
    font-size: 2rem;
    font-weight: 800;
    background: linear-gradient(135deg, #06b6d4 0%, #3b82f6 50%, #8b5cf6 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin-bottom: 0.25rem;
}

.stat-label {
    color: #94a3b8;
    font-size: 0.875rem;
}

.stat-divider {
    width: 1px;
    height: 50px;
    background: rgba(59, 130, 246, 0.2);
}

.deco-square {
    position: absolute;
    border: 2px solid rgba(59, 130, 246, 0.1);
    border-radius: 1rem;
    animation: rotate 30s linear infinite;
}

.square-1 {
    width: 200px;
    height: 200px;
    top: 10%;
    right: -50px;
}

.square-2 {
    width: 150px;
    height: 150px;
    bottom: 20%;
    right: -30px;
    animation-delay: -15s;
}

.deco-circle {
    position: absolute;
    border-radius: 50%;
    border: 2px solid rgba(59, 130, 246, 0.1);
    animation: rotate 25s linear infinite reverse;
}

.circle-1 {
    width: 180px;
    height: 180px;
    bottom: -50px;
    left: -50px;
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

@keyframes slideInRight {
    from {
        opacity: 0;
        transform: translateX(30px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

/* Responsive */
@media (max-width: 1024px) {
    .register-container {
        grid-template-columns: 1fr;
        max-width: 550px;
    }

    .benefits-panel {
        display: none;
    }

    .form-panel {
        border-right: none;
    }
}

@media (max-width: 640px) {
    .register-page {
        padding: 1rem 0;
    }

    .form-panel {
        padding: 2rem 1.5rem;
    }

    .form-title {
        font-size: 1.75rem;
    }

    .social-buttons {
        grid-template-columns: 1fr;
    }

    .logo-section {
        flex-direction: column;
        align-items: flex-start;
    }
}
</style>