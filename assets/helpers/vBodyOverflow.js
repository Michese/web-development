export default {
    mounted() {
        const body = document.querySelector('body');
        if (body) {
            body.style.overflowY = 'hidden';
        }
    },
    unmounted() {
        const body = document.querySelector('body');
        if (body) {
            body.style.overflowY = 'auto';
        }
    },
};