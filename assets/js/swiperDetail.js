import Swiper from 'swiper';
import { Autoplay, Navigation} from 'swiper/modules';

import 'swiper/scss';
import 'swiper/scss/navigation';
import 'swiper/scss/pagination';

const swiper = new Swiper('.detail-slider', {
    modules: [Autoplay, Navigation],
    loop: true,
    grabCursor: true,
    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
        
    },
    autoplay: {
        disableOnInteraction: true,
        delay: 3500,
    }
});

