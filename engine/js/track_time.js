setInterval(function() {
    fetch('/engine/account/track_time.php', { method: 'POST', credentials: 'same-origin' })
        .then(res => res.json())
        .then(data => {
        });
}, 300000);