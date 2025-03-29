import { Swiper, SwiperSlide } from 'swiper/react';
import { Navigation, Pagination, Autoplay, EffectCoverflow } from 'swiper/modules';
import { useState, useEffect } from 'react';
import 'swiper/css';
import 'swiper/css/bundle';

/**
 * Componente Carrusel.
 * 
 * Este componente renderiza un carrusel interactivo utilizando Swiper.js. 
 * Es ideal para mostrar una serie de imágenes con efectos visuales atractivos.
 * 
 * @param {Object} props - Propiedades del componente.
 * @param {string} [props.className] - Clase CSS opcional para personalizar el estilo del carrusel.
 * @param {string[]} [props.imagenes] - Arreglo de URLs de imágenes que se mostrarán en el carrusel.
 * @param {number} [props.numSlide] - Número de diapositivas visibles al mismo tiempo. Por defecto es 1.
 * 
 * @returns {JSX.Element | null} - Devuelve el carrusel renderizado o `null` si no se proporcionan imágenes.
 * 
 * @example
 * ```tsx
 * import Carrusel from './Carrusel';
 * 
 * const imagenes = [
 *   'https://example.com/imagen1.jpg',
 *   'https://example.com/imagen2.jpg',
 *   'https://example.com/imagen3.jpg'
 * ];
 * 
 * <Carrusel 
 *   className="mi-clase-personalizada" 
 *   numSlide={3} 
 *   imagenes={imagenes} 
 * />;
 * ```
 * 
 * @remarks
 * - Este componente utiliza los módulos `Navigation`, `Pagination`, `Autoplay` y `EffectCoverflow` de Swiper.js.
 * - Incluye un efecto de "coverflow" para las diapositivas.
 * - Las imágenes se ajustan automáticamente al contenedor con un diseño responsivo.
 * - El carrusel se reproduce automáticamente con un retraso de 4 segundos entre diapositivas.
 */


export default function Carrusel({ className, numSlide, imagenes }: { className?: string, numSlide?: number, imagenes?: string[] }) {
    const [isReady, setIsReady] = useState(false);
    useEffect(() => {
        setIsReady(true);
    }, []);



    if (!isReady) return <div className={className}></div>;
    if (!imagenes) return null;
    return (
        <Swiper
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
            autoplay={{ delay: 2000, disableOnInteraction: true }}
            onAutoplayStop={() => console.log("Autoplay stopped")}
            onAutoplayStart={() => console.log("Autoplay started")}
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
