import { Swiper, SwiperSlide } from 'swiper/react';
import { Navigation, Pagination, Autoplay, EffectCoverflow } from 'swiper/modules';
import { useState, useEffect, useRef } from 'react';
import 'swiper/css';
import 'swiper/css/bundle';

export default function Carrusel({ className, numSlide, imagenes }: { className?: string, numSlide?: number, imagenes?: string[] }) {
    const [isReady, setIsReady] = useState(false);
    const swiperRef = useRef<any>(null);
    const inactivityTimeout = useRef<ReturnType<typeof setTimeout> | null>(null);
    useEffect(() => {
        setIsReady(true);
    }, []);

    if (!isReady) return <div className={className}></div>;
    if (!imagenes) return null;

    const handleInteraction = () => {
        if (swiperRef.current) {
            swiperRef.current.autoplay.stop();
        }
        if (inactivityTimeout.current) {
            clearTimeout(inactivityTimeout.current);
        }
        inactivityTimeout.current = setTimeout(() => {
            if (swiperRef.current) {
                swiperRef.current.autoplay.start();
            }
        }, 10000);
    };

    return (
        <Swiper
            ref={swiperRef}
            modules={[Navigation, Pagination, Autoplay, EffectCoverflow]}
            navigation
            pagination={{ clickable: true }}
            className={className || "max-w-screen-sm relative"}
            effect="coverflow"
            grabCursor={true}
            centeredSlides={true}
            slidesPerView={numSlide || 1}
            coverflowEffect={{
                rotate: 0,
                stretch: 0,
                depth: 200,
                modifier: 2.5,
                slideShadows: true
            }}
            loop={true}
            autoplay={{ delay: 2000, disableOnInteraction: false }}
            onSwiper={(swiper) => (swiperRef.current = swiper)}
            onMouseEnter={handleInteraction}
            onMouseLeave={handleInteraction}
            onTouchStart={handleInteraction}
            onTouchEnd={handleInteraction}
        >
            {imagenes.map((imagen, index) => (
                <SwiperSlide
                    key={index}
                    className=" w-[22rem] h-[12rem] transition-all duration-300 ease-in-out 
                   swiper-slide-active:w-[28rem] swiper-slide-active:h-[16rem]"
                >
                    <div className=" w-full h-full">
                        <img
                            src={imagen}
                            alt={`Slide ${index + 1}`}
                            className="w-full h-full object-cover rounded-xl shadow-lg transition-all duration-300"
                        />
                    </div>
                </SwiperSlide>
            ))}
        </Swiper>

    );
}