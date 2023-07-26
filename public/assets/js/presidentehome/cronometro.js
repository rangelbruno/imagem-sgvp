  // Get the end time
  const endTime = new Date();
  endTime.setHours(endTime.getHours() + 4);

  function calculateTimeDifference() {
      const now = new Date();
      let diff = endTime - now;

      // Calculate hours, minutes, and seconds
      let hours = Math.floor(diff / 1000 / 60 / 60);
      diff -= hours * 1000 * 60 * 60;
      let minutes = Math.floor(diff / 1000 / 60);
      diff -= minutes * 1000 * 60;
      let seconds = Math.floor(diff / 1000);

      return {
          hours: hours,
          minutes: minutes,
          seconds: seconds
      };
  }

  function updateCountdown() {
      const timeDiff = calculateTimeDifference();
      const {
          hours,
          minutes,
          seconds
      } = timeDiff;

      // Update the countdown
      document.getElementById('countdown').textContent =
          `${padNumber(hours)}:${padNumber(minutes)}:${padNumber(seconds)}`;

      // Schedule the next update
      setTimeout(updateCountdown, 1000);
  }

  function padNumber(number) {
      return number.toString().padStart(2, '0');
  }

  // Start the countdown
  updateCountdown();