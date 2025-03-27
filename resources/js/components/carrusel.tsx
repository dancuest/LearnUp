import { Swiper, SwiperSlide } from 'swiper/react';
import { Navigation, Pagination, Scrollbar, A11y } from 'swiper/modules';
import { useState, useEffect } from 'react';
import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';
import 'swiper/css/scrollbar';



export default function Carrusel() {
    const [isReady, setIsReady] = useState(false);

    useEffect(() => {
        setIsReady(true);
    }, []);

    if (!isReady) return <div className="w-full h-[400px] bg-gray-200"></div>;

    return (
        <Swiper
            modules={[Navigation, Pagination, Scrollbar, A11y]}
            spaceBetween={50}
            slidesPerView={1}
            navigation
            pagination={{ clickable: true }}
            scrollbar={{ draggable: true }}
            className="w-full max-w-[600px] h-[400px]"
        >
            <SwiperSlide><img src="https://i.pinimg.com/736x/54/a4/b9/54a4b9cbb20db0f633ede925c05ad35d.jpg" alt="Slide 1" /></SwiperSlide>
            <SwiperSlide><img src="https://i.pinimg.com/736x/e2/d2/fe/e2d2fe99663babfd6ecfea6ba655ad72.jpg" alt="Slide 2" /></SwiperSlide>
        </Swiper>
    );
}
