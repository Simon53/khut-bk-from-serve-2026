// search.js
document.addEventListener('DOMContentLoaded', function () {

    const searchInput = document.getElementById('searchInput');

    if (!searchInput) return;

    searchInput.addEventListener('keydown', function (e) {

        if (e.key === 'Enter') {
            e.preventDefault();

            let q = this.value.trim();
            if (q.length < 2) return;

            fetch(`${window.BASE_URL}/search?q=${encodeURIComponent(q)}`)
                .then(res => res.json())
                .then(data => {
                    if (data.slug) {
                        window.location.href =
                            `${window.BASE_URL}/product-details/${data.slug}`;
                    } else {
                        alert('Product not found');
                    }
                })
                .catch(err => console.error(err));
        }

    });

});
