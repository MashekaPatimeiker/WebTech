window.addEventListener('DOMContentLoaded', () => {
    if (window.lucide) lucide.createIcons();
    const params = new URLSearchParams(window.location.search);
    const msg = params.get("msg");
    if (msg) {
        alert(decodeURIComponent(msg));
    }

    const previewBox = document.querySelector(".file-preview");

    document.querySelectorAll("a.file").forEach(link => {
        const href = link.getAttribute("href");
        if (/\.(jpe?g|png|gif|webp|bmp|svg)$/i.test(href)) {
            link.addEventListener("mouseenter", e => {
                const rect = link.getBoundingClientRect();
                const img = document.createElement("img");
                img.src = href;

                previewBox.innerHTML = "";
                previewBox.appendChild(img);
                previewBox.style.top = (rect.bottom + window.scrollY + 5) + "px";
                previewBox.style.left = (rect.left + window.scrollX) + "px";
                previewBox.style.display = "block";
            });
            link.addEventListener("mouseleave", () => {
                previewBox.style.display = "none";
            });
        }
    });
});

