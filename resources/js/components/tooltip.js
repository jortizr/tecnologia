// resources/js/components/tooltip.js
export default () => ({
    showTooltip: false,

    // Puedes agregar una propiedad para el texto del tooltip
    // x-text="message" en el HTML
    message: '',

    init() {
        // Opcional: Si quieres que el mensaje se pase como un atributo
        // <div x-data="tooltipComponent('Mi mensaje')">
        if (typeof this.$el.dataset.message !== 'undefined') {
            this.message = this.$el.dataset.message;
        }
    }
});
