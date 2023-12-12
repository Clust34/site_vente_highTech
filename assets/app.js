/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.scss';

import AOS from 'aos';
import 'aos/dist/aos.css'; // You can also use <link> for styles
// ..
AOS.init();

// Import Javascript
import './js/slider';
import './js/addCollectionInput';
import './js/swiperDetail';
import './js/swiperHome';
import './js/menuBurger';
import './js/switchTelphoneActif';
import './js/showPassword';
import './js/switchTablettes';
import './js/switchOrdinateurs';


// Import assets/images 
import './Images/construction.jpg';
import './Images/logo.1.ico';
import './Images/ban-laptop.jpg';
import './Images/ban-tablette.png';
import './Images/ban-telephone.jpg';
