document.addEventListener('DOMContentLoaded', () => {
    const seats = document.querySelectorAll('.seat');
    const urlParams = new URLSearchParams(window.location.search);
    const movieName = urlParams.get('movie');

    if (movieName) {
        document.getElementById('movieName').value = movieName;
    }

    seats.forEach(seat => {
        seat.addEventListener('click', () => {
            seat.classList.toggle('selected');
            updateSelectedSeatsInfo();
            updateAmount();
        });
    });

    function updateSelectedSeatsInfo() {
        const selectedSeats = document.querySelectorAll('.seat.selected');
        const selectedSeatsInput = document.getElementById('selectedSeats');
        const selectedSeatsArray = Array.from(selectedSeats).map(seat => seat.getAttribute('data-seat-number'));
        selectedSeatsInput.value = selectedSeatsArray.join(', ');
    }

    function updateAmount() {
        const selectedSeatsCount = document.querySelectorAll('.seat.selected').length;
        const pricePerSeat = 100; // Replace with your actual price per seat
        const totalAmount = selectedSeatsCount * pricePerSeat;
        document.getElementById('amount').value = totalAmount;
    }
});


document.addEventListener('DOMContentLoaded', () => {
    const urlParams = new URLSearchParams(window.location.search);
    const movieName = urlParams.get('movie'); // Assuming you fetch the movie name from URL params
    
    if (movieName) {
        document.getElementById('movieName').value = movieName; // Set movie name in the hidden input field
    }
});