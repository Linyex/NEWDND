document.addEventListener('DOMContentLoaded', function() {
    const timeElem = document.getElementById('realtime-total-time');
    if (!timeElem) return;
    let totalMinutes = parseInt(timeElem.dataset.totalTime) || 0;
    let seconds = totalMinutes * 60;
    function formatTime(sec) {
        const h = Math.floor(sec / 3600);
        const m = Math.floor((sec % 3600) / 60);
        const s = sec % 60;
        let res = '';
        if (h > 0) res += h + ' ч ';
        if (m > 0 || h > 0) res += m + ' мин ';
        res += s + ' сек';
        return res;
    }
    function updateTime() {
        seconds++;
        timeElem.textContent = formatTime(seconds);
    }
    timeElem.textContent = formatTime(seconds);
    setInterval(updateTime, 1000);
}); 