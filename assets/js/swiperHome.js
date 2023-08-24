import Swiper from 'swiper';
import { Autoplay, Navigation, Pagination} from 'swiper/modules';

import 'swiper/scss';
import 'swiper/scss/navigation';
import 'swiper/scss/pagination';

const swiper2 = new Swiper(".mySwiper", {
    modules: [Autoplay, Navigation, Pagination],
    loop: true,
    pagination: {
      el: ".swiper-pagination",
      type: "progressbar",
      clickable: true,
    },
    navigation: {
      nextEl: ".swiper-button-next",
      prevEl: ".swiper-button-prev",
    },
    autoplay: {
        disableOnInteraction: true,
        delay: 3500,
    }
  });