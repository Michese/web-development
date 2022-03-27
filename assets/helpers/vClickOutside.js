export default {
    mounted(el, { value }) {
        el.addEventListener('click', (event) => event.stopPropagation());
        document.body.addEventListener('click', value);
    },
    unmounted(el, { value }) {
        document.body.removeEventListener('click', value);
    },
};