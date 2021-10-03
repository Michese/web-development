export default {
  mounted(): void {
    const body = document.querySelector('body');
    if (body) {
      body.style.overflowY = 'hidden';
    }
  },
  unmounted(): void {
    const body = document.querySelector('body');
    if (body) {
      body.style.overflowY = 'auto';
    }
  },
};