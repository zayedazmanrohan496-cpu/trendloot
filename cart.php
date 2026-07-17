<?php
/**
 * Plugin Name: WooCommerce Custom Product Styles & Text Changes
 * Plugin URI:  https://yourdomain.com
 * Description: Changes WooCommerce "Add to Cart" button text to "Buy Now", customizes product grid layouts, borders, and colors to match a beautiful dark (#111111) theme.
 * Version:     1.0.0
 * Author:      Zayed Azman Rohan
 * License:     GPL2
 */

// নিরাপত্তা নিশ্চিত করতে সরাসরি ফাইল অ্যাক্সেস বন্ধ করা
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

/**
 * ১. 'Add to Cart' টেক্সট পরিবর্তন করে 'Buy Now' করা (লুপ এবং সিঙ্গেল পেজ উভয়ের জন্য)
 */
add_filter( 'woocommerce_product_add_to_cart_text', 'custom_woocommerce_product_btn_text', 20 );
add_filter( 'woocommerce_product_single_add_to_cart_text', 'custom_woocommerce_product_btn_text', 20 );
function custom_woocommerce_product_btn_text() {
    return __( 'Buy Now', 'woocommerce' );
}

/**
 * ২. প্রোডাক্ট সেকশনের ডিজাইন ও কালার পরিবর্তনের জন্য CSS ইনজেকশন
 */
add_action( 'wp_head', 'custom_woocommerce_product_section_styles' );
function custom_woocommerce_product_section_styles() {
    ?>
    <style type="text/css">
        /* প্রোডাক্ট বক্সের জন্য ইউনিক ও সুন্দর বর্ডার এবং শ্যাডো */
        ul.products li.product {
            position: relative !important; /* View Cart এবসোলিউট পজিশন করার জন্য */
            border: 1px solid #e5e7eb !important;
            border-radius: 12px !important; /* কোণাগুলো সুন্দরভাবে গোল করার জন্য */
            padding: 20px !important;
            background: #ffffff !important;
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1) !important;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03) !important;
        }

        /* প্রোডাক্ট বক্সে মাউস নিলে (Hover) ইউনিক ইফেক্ট */
        ul.products li.product:hover {
            border-color: #111111 !important;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.08) !important;
            transform: translateY(-5px) !important;
        }

        /* প্রোডাক্ট ইমেজকে বক্সে সুন্দরভাবে ফিট করা */
        ul.products li.product img {
            border-radius: 8px !important;
            margin-bottom: 15px !important;
        }

        /* প্রোডাক্ট টাইটেল/ট্যাগ এবং প্রাইসের কালার #111111 করা */
        ul.products li.product .woocommerce-loop-product__title,
        ul.products li.product .price,
        ul.products li.product .price ins,
        ul.products li.product .price del,
        ul.products li.product .price .amount {
            color: #111111 !important;
            font-weight: 600 !important;
        }
        
        ul.products li.product .woocommerce-loop-product__title {
            font-size: 16px !important;
            margin-bottom: 8px !important;
        }

        /* Buy Now বাটনের ব্যাকগ্রাউন্ড কালার #111111 এবং টেক্সট কালার হোয়াইট */
        ul.products li.product .button.add_to_cart_button {
            position: relative !important;
            background-color: #111111 !important;
            color: #ffffff !important;
            border: 1px solid #111111 !important;
            border-radius: 6px !important;
            padding: 12px 20px !important;
            font-weight: 600 !important;
            text-transform: uppercase !important;
            font-size: 13px !important;
            letter-spacing: 0.5px !important;
            transition: all 0.2s ease-in-out !important;
            display: block !important;
            text-align: center !important;
            margin-top: 15px !important;
        }

        /* বাটনে মাউস নিলে (Hover) সামান্য স্টাইল পরিবর্তন */
        ul.products li.product .button.add_to_cart_button:hover {
            background-color: #2d2d2d !important;
            border-color: #2d2d2d !important;
            color: #ffffff !important;
        }

        /* ইমেজে থাকা Sale! ব্যাজের কালার সামঞ্জস্যপূর্ণ করা */
        ul.products li.product .onsale {
            background-color: #111111 !important;
            color: #ffffff !important;
            font-weight: 500 !important;
        }

        /* =================================================================
           ভিউ কার্ট (View Cart) বাটনটিকে মেইন বাটনের ভেতরে ওভারলে করার ম্যাজিক CSS
           ================================================================= */
        ul.products li.product a.added_to_cart.wc-forward {
            position: absolute !important;
            top: 0 !important;
            left: 0 !important;
            width: 100% !important;
            height: 100% !important;
            background-color: #111111 !important; /* বাটনের ব্যাকগ্রাউন্ড কালার */
            color: #ffffff !important; /* ভিউ কার্ট লেখার কালার */
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            border-radius: 6px !important;
            font-weight: 600 !important;
            text-transform: uppercase !important;
            font-size: 13px !important;
            letter-spacing: 0.5px !important;
            text-decoration: none !important;
            z-index: 10 !important;
            transition: all 0.2s ease-in-out !important;
        }

        /* ভিউ কার্ট বাটনে মাউস নিলে বাটন একটু হালকা হবে */
        ul.products li.product a.added_to_cart.wc-forward:hover {
            background-color: #2d2d2d !important;
        }

        /* AJAX দিয়ে লোড হওয়ার সময় মূল বাটনের রিলেটিভ পজিশন ঠিক রাখা */
        ul.products li.product .button.add_to_cart_button.added {
            /* যখন প্রোডাক্ট অ্যাড হয়ে যাবে, তখন মূল বাটনটি ব্যাকগ্রাউন্ডে ঢাকা পড়ে যাবে */
            visibility: visible !important; 
        }
    </style>
    <?php
}