import clickOutside from '../directives/click-ouside.js';
import trimEmptyTextNodes from '../directives/trim-whitespace.js';

/**
 * You can register global directives here and use them as a plugin in your main Vue instance
 */

const GlobalDirectives = {
  install(Vue) {
    Vue.directive('click-outside', clickOutside);
    Vue.directive('trim-whitespace', trimEmptyTextNodes);
  }
};

export default GlobalDirectives;
