
// HANDLE CEHCKBOX LOGIC
document.addEventListener('DOMContentLoaded', function () {
    const toggle = document.getElementById('togglePassword');
    const password = document.getElementById('password');

    toggle.addEventListener('change', function () {
        console.log('checked');
        password.type = this.checked ? 'text' : 'password';
    });
});

// HANDEL FETCH NEW QUOTE
document.addEventListener("DOMContentLoaded", () => {
    const quoteText = document.getElementById('quoteText');
    const loadBtn = document.getElementById('loadNewQuote');

    async function loadQuote() {
        try {
            const res = await fetch('get_quote.php');
            const data = await res.json();

            if (data.quote) {
                quoteText.innerHTML = `<em>${data.quote}</em> <br>— ${data.author}`;
            } else {
                quoteText.innerHTML = 'Could not load quote.';
            }
        } catch (err) {
            quoteText.innerHTML = 'Error fetching quote.';
        }
    }

    loadBtn.addEventListener('click', loadQuote);

});
loadQuote();
