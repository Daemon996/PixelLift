# 📌 PixelLift - Progressive Image Loading for WordPress

**Contributors:** Nathan Courtney  
**Plugin Name:** PixelLift  
**Version:** 1.0  
**Requires at least:** 5.0  
**Tested up to:** 6.4  
**Requires PHP:** 7.4  
**License:** GPL-2.0+  
**License URI:** [GNU GPL-2.0](https://www.gnu.org/licenses/gpl-2.0.html)  
**Tags:** images, lazy loading, progressive loading, srcset, performance  
**Website:** [dev.nathancourtney.com](https://dev.nathancourtney.com)  

---

## 🚀 Description

PixelLift intelligently replaces images in WordPress posts and pages, starting with a lower-quality version and progressively loading higher-quality variations.

### 🔹 Key Features:
- ✅ **Smart Progressive Loading** – Loads low-resolution images first, then upgrades quality dynamically.
- ✅ **Lazy Loading** – Optimized for performance and smooth scrolling.
- ✅ **Respects Original Size** – Never upscales beyond the author's selected size.
- ✅ **Admin Settings Panel** – Choose whether to start with low or medium-quality images.
- ✅ **Fully Automated** – Works with existing WordPress images without extra setup.

---

## ⚙️ Installation

1. **Download & Upload:**  
   - Download the PixelLift plugin ZIP file.  
   - Upload it to your WordPress site under `wp-content/plugins/`.  

2. **Activate:**  
   - Go to **Plugins > Installed Plugins** and activate **PixelLift**.  

3. **Configure Settings:**  
   - Navigate to **Settings > PixelLift** in your WordPress admin panel.  
   - Choose whether images should start in **Low Quality** or **Medium Quality**.  

4. **Enjoy a Faster Site!** 🎉  

---

## 🛠️ How It Works

1. **Replaces `src` with the smallest available `srcset` image** (low/medium).  
2. **Stores the full `srcset` for progressive upgrading** via JavaScript.  
3. **Ensures the displayed size remains unchanged** (prevents layout shifts).  
4. **Gradually upgrades images** to the next best available resolution.  

---

## 📌 Frequently Asked Questions

### ❓ Will this affect my original images?
No, PixelLift only modifies how images are displayed. Your actual media files remain untouched.

### ❓ Can I disable progressive loading?
Currently, there’s no toggle to disable it, but you can deactivate the plugin if needed.

### ❓ Does this work with all themes?
Yes! PixelLift works with any WordPress theme that correctly implements `srcset`.

---

## 📝 Changelog

### **1.0** – *Initial Release*
- Progressive image loading from low to high quality  
- Lazy loading support  
- Admin settings page  

---

## 👨‍💻 Support & Contact
For support, feature requests, or contributions, visit [dev.nathancourtney.com](https://dev.nathancourtney.com) or email **[contact@nathancourtney.com](mailto:contact@nathancourtney.com)**.  
