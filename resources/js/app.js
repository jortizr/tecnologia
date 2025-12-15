import './bootstrap';


import TooltipComponent from './components/tooltip';

import TomSelect from 'tom-select';
import 'tom-select/dist/css/tom-select.default.css';

// Haz que TomSelect esté disponible en la ventana (globalmente) para que x-init pueda usarlo
window.TomSelect = TomSelect;
window.Alpine = Alpine;

Alpine.data('tooltipComponent', TooltipComponent);
