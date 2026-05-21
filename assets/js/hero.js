    const slides = document.querySelectorAll(".slide");
    const dots = document.querySelectorAll(".dot");

    let currentSlide = 0;

    function showSlide(index) {

        slides.forEach((slide, i) => {
            slide.classList.toggle("opacity-100", i === index);
            slide.classList.toggle("opacity-0", i !== index);
        });

        dots.forEach((dot, i) => {
            dot.classList.toggle("bg-yellow-500", i === index);
            dot.classList.toggle("bg-white/30", i !== index);
        });

        currentSlide = index;
    }

    dots.forEach((dot, index) => {
        dot.addEventListener("click", () => {
            showSlide(index);
        });
    });

    setInterval(() => {
        let nextSlide = (currentSlide + 1) % slides.length;
        showSlide(nextSlide);
    }, 5000);
