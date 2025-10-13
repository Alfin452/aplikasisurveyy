import "./bootstrap";

// --- PERBAIKAN: Impor dan jalankan Alpine.js ---
import Alpine from "alpinejs";
window.Alpine = Alpine;
Alpine.start();
// --- AKHIR PERBAIKAN ---

// Impor GSAP dan plugin yang diperlukan
import { gsap } from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";
import { ScrollToPlugin } from "gsap/ScrollToPlugin";

// Daftarkan plugin-plugin tersebut
gsap.registerPlugin(ScrollTrigger, ScrollToPlugin);

// Tunggu hingga seluruh halaman siap sebelum menjalankan animasi
document.addEventListener("DOMContentLoaded", function () {
    // --- 1. Animasi Timeline Pemuatan Awal (Header & Hero) ---
    const tl = gsap.timeline({ defaults: { ease: "power2.out" } });

    tl.from(".header-anim", { yPercent: -100, duration: 0.8 })
        .from(".hero-title-anim", { opacity: 0, y: 30, duration: 0.6 }, "-=0.4")
        .from(
            ".hero-subtitle-anim",
            { opacity: 0, y: 20, duration: 0.5 },
            "-=0.3"
        )
        .from(
            ".hero-button-anim",
            { opacity: 0, scale: 0.8, duration: 0.5 },
            "-=0.3"
        )
        .from(
            ".hero-image-anim",
            { opacity: 0, scale: 0.9, duration: 1, ease: "power3.out" },
            "-=0.5"
        );

    // --- 2. Animasi ScrollTrigger ---

    gsap.utils.toArray(".section-title-anim").forEach((title) => {
        gsap.to(title, {
            opacity: 1,
            y: 0,
            duration: 0.8,
            ease: "power2.out",
            scrollTrigger: {
                trigger: title,
                start: "top 85%",
                toggleActions: "play none none none",
            },
        });
    });

    gsap.to(".feature-card-anim", {
        opacity: 1,
        y: 0,
        duration: 0.6,
        ease: "power2.out",
        stagger: 0.2,
        scrollTrigger: {
            trigger: ".feature-section",
            start: "top 70%",
            toggleActions: "play none none none",
        },
    });

    gsap.to(".survey-item-anim", {
        opacity: 1,
        y: 0,
        duration: 0.7,
        ease: "power2.out",
        stagger: 0.15,
        scrollTrigger: {
            trigger: ".survey-section",
            start: "top 75%",
            toggleActions: "play none none none",
        },
    });

    // --- 3. Fungsionalitas Navigasi ---
    const navLinks = gsap.utils.toArray(".nav-link-anim");
    const sections = gsap.utils.toArray(".section-nav");

    navLinks.forEach((link) => {
        link.addEventListener("click", (e) => {
            e.preventDefault();
            const targetId = e.target.getAttribute("href");
            const mobileMenuElement = document.querySelector(
                '[x-data="{ mobileMenuOpen: false }"]'
            );
            if (
                mobileMenuElement &&
                mobileMenuElement.__x &&
                mobileMenuElement.__x.$data.mobileMenuOpen
            ) {
                mobileMenuElement.__x.$data.mobileMenuOpen = false;
            }
            gsap.to(window, {
                duration: 1.2,
                scrollTo: { y: targetId, offsetY: 80 },
                ease: "power3.inOut",
            });
        });
    });

    sections.forEach((section) => {
        ScrollTrigger.create({
            trigger: section,
            start: "top center",
            end: "bottom center",
            onToggle: (self) => {
                const targetLink = document.querySelector(
                    `a[href="#${section.id}"]`
                );
                if (targetLink) {
                    self.isActive
                        ? targetLink.classList.add("nav-active")
                        : targetLink.classList.remove("nav-active");
                }
            },
        });
    });
});
