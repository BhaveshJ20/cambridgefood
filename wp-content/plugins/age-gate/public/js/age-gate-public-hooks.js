!function(e){function t(r){if(n[r])return n[r].exports;var o=n[r]={i:r,l:!1,exports:{}};return e[r].call(o.exports,o,o.exports,t),o.l=!0,o.exports}var n={};t.m=e,t.c=n,t.d=function(e,n,r){t.o(e,n)||Object.defineProperty(e,n,{configurable:!1,enumerable:!0,get:r})},t.n=function(e){var n=e&&e.__esModule?function(){return e.default}:function(){return e};return t.d(n,"a",n),n},t.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},t.p="/",t(t.s=17)}([function(e,t,n){"use strict";Object.defineProperty(t,"__esModule",{value:!0}),t.filters=t.actions=t.didFilter=t.didAction=t.doingFilter=t.doingAction=t.currentFilter=t.currentAction=t.applyFilters=t.doAction=t.removeAllFilters=t.removeAllActions=t.hasFilter=t.hasAction=t.removeFilter=t.removeAction=t.addFilter=t.addAction=t.createHooks=void 0;var r=n(19),o=function(e){return e&&e.__esModule?e:{default:e}}(r),u=(0,o.default)(),i=u.addAction,l=u.addFilter,c=u.removeAction,d=u.removeFilter,a=u.hasAction,f=u.hasFilter,s=u.removeAllActions,_=u.removeAllFilters,v=u.doAction,p=u.applyFilters,A=u.currentAction,y=u.currentFilter,h=u.doingAction,m=u.doingFilter,F=u.didAction,b=u.didFilter,g=u.actions,M=u.filters;t.createHooks=o.default,t.addAction=i,t.addFilter=l,t.removeAction=c,t.removeFilter=d,t.hasAction=a,t.hasFilter=f,t.removeAllActions=s,t.removeAllFilters=_,t.doAction=v,t.applyFilters=p,t.currentAction=A,t.currentFilter=y,t.doingAction=h,t.doingFilter=m,t.didAction=F,t.didFilter=b,t.actions=g,t.filters=M},function(e,t,n){"use strict";function r(e){return"string"==typeof e&&""!==e&&!/^__/.test(e)&&!!/^[a-zA-Z][a-zA-Z0-9_.-]*$/.test(e)}Object.defineProperty(t,"__esModule",{value:!0}),t.default=r},function(e,t,n){"use strict";function r(e){return"string"==typeof e&&""!==e&&!!/^[a-zA-Z][a-zA-Z0-9_.\-\/]*$/.test(e)}Object.defineProperty(t,"__esModule",{value:!0}),t.default=r},,,,,,,,,,,,,,,function(e,t,n){"use strict";(function(e){var t=n(0);e.ageGateHooks=(0,t.createHooks)()}).call(t,n(18))},function(e,t,n){"use strict";var r,o="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(e){return typeof e}:function(e){return e&&"function"==typeof Symbol&&e.constructor===Symbol&&e!==Symbol.prototype?"symbol":typeof e};r=function(){return this}();try{r=r||Function("return this")()||(0,eval)("this")}catch(e){"object"===("undefined"==typeof window?"undefined":o(window))&&(r=window)}e.exports=r},function(e,t,n){"use strict";function r(e){return e&&e.__esModule?e:{default:e}}function o(){var e=Object.create(null),t=Object.create(null);return e.__current=[],t.__current=[],{addAction:(0,i.default)(e),addFilter:(0,i.default)(t),removeAction:(0,c.default)(e),removeFilter:(0,c.default)(t),hasAction:(0,a.default)(e),hasFilter:(0,a.default)(t),removeAllActions:(0,c.default)(e,!0),removeAllFilters:(0,c.default)(t,!0),doAction:(0,s.default)(e),applyFilters:(0,s.default)(t,!0),currentAction:(0,v.default)(e),currentFilter:(0,v.default)(t),doingAction:(0,A.default)(e),doingFilter:(0,A.default)(t),didAction:(0,h.default)(e),didFilter:(0,h.default)(t),actions:e,filters:t}}Object.defineProperty(t,"__esModule",{value:!0});var u=n(20),i=r(u),l=n(21),c=r(l),d=n(22),a=r(d),f=n(23),s=r(f),_=n(24),v=r(_),p=n(25),A=r(p),y=n(26),h=r(y);t.default=o},function(e,t,n){"use strict";function r(e){return e&&e.__esModule?e:{default:e}}function o(e){return function(t,n,r){var o=arguments.length>3&&void 0!==arguments[3]?arguments[3]:10;if((0,c.default)(t)&&(0,i.default)(n)&&"function"==typeof r&&"number"==typeof o){var u={callback:r,priority:o,namespace:n};if(e[t]){var l,a=e[t].handlers;for(l=a.length;l>0&&!(o>=a[l-1].priority);l--);l===a.length?a[l]=u:a.splice(l,0,u),(e.__current||[]).forEach(function(e){e.name===t&&e.currentIndex>=l&&e.currentIndex++})}else e[t]={handlers:[u],runs:0};"hookAdded"!==t&&(0,d.doAction)("hookAdded",t,n,r,o)}}}Object.defineProperty(t,"__esModule",{value:!0});var u=n(2),i=r(u),l=n(1),c=r(l),d=n(0);t.default=o},function(e,t,n){"use strict";function r(e){return e&&e.__esModule?e:{default:e}}function o(e,t){return function(n,r){if((0,c.default)(n)&&(t||(0,i.default)(r))){if(!e[n])return 0;var o=0;if(t)o=e[n].handlers.length,e[n]={runs:e[n].runs,handlers:[]};else for(var u=e[n].handlers,l=u.length-1;l>=0;l--)!function(t){u[t].namespace===r&&(u.splice(t,1),o++,(e.__current||[]).forEach(function(e){e.name===n&&e.currentIndex>=t&&e.currentIndex--}))}(l);return"hookRemoved"!==n&&(0,d.doAction)("hookRemoved",n,r),o}}}Object.defineProperty(t,"__esModule",{value:!0});var u=n(2),i=r(u),l=n(1),c=r(l),d=n(0);t.default=o},function(e,t,n){"use strict";function r(e){return function(t){return t in e}}Object.defineProperty(t,"__esModule",{value:!0}),t.default=r},function(e,t,n){"use strict";function r(e,t){return function(n){e[n]||(e[n]={handlers:[],runs:0}),e[n].runs++;for(var r=e[n].handlers,o=arguments.length,u=new Array(o>1?o-1:0),i=1;i<o;i++)u[i-1]=arguments[i];if(!r||!r.length)return t?u[0]:void 0;var l={name:n,currentIndex:0};for(e.__current.push(l);l.currentIndex<r.length;){var c=r[l.currentIndex],d=c.callback.apply(null,u);t&&(u[0]=d),l.currentIndex++}return e.__current.pop(),t?u[0]:void 0}}Object.defineProperty(t,"__esModule",{value:!0}),t.default=r},function(e,t,n){"use strict";function r(e){return function(){return e.__current&&e.__current.length?e.__current[e.__current.length-1].name:null}}Object.defineProperty(t,"__esModule",{value:!0}),t.default=r},function(e,t,n){"use strict";function r(e){return function(t){return void 0===t?void 0!==e.__current[0]:!!e.__current[0]&&t===e.__current[0].name}}Object.defineProperty(t,"__esModule",{value:!0}),t.default=r},function(e,t,n){"use strict";function r(e){return function(t){if((0,u.default)(t))return e[t]&&e[t].runs?e[t].runs:0}}Object.defineProperty(t,"__esModule",{value:!0});var o=n(1),u=function(e){return e&&e.__esModule?e:{default:e}}(o);t.default=r}]);