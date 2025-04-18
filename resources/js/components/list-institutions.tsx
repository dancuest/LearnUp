import React, { useState } from 'react';
import { Card, CardDescription, CardTitle } from './ui/card';
import SearchInstitutions from './search-institutions';

interface Institution {
    id: number;
    nombre: string;
    descripcion: string;
    imagen_perfil: string;
}

/**
 * Componente funcional de React que muestra una lista de instituciones educativas.
 * 
 * @component
 * 
 * @returns {JSX.Element} Un componente que renderiza un título, un buscador de instituciones
 * y una lista de tarjetas con información de las instituciones encontradas.
 * 
 * @description
 * Este componente utiliza un estado local para almacenar las instituciones obtenidas
 * a través del componente `SearchInstitutions`. Cada institución se muestra en una tarjeta
 * que incluye una imagen de fondo, un título y una descripción truncada.
 * 
 * - Si no hay instituciones disponibles, se muestra un mensaje indicando que no hay datos.
 * - La descripción de cada institución se trunca a un número máximo de palabras definido
 * por la función `truncateDescription`.
 * 
 * @function truncateDescription
 * @param {string} description - La descripción completa de la institución.
 * @param {number} maxWords - El número máximo de palabras permitidas en la descripción truncada.
 * @returns {string} La descripción truncada con un sufijo de puntos suspensivos (`...`) si excede el límite.
 * 
 * @example
 * ```tsx
 * <ListInstitutions />
 * ```
 * 
 * @remarks
 * - Este componente utiliza clases de Tailwind CSS para el diseño y estilos.
 * - Las tarjetas tienen efectos de hover para mejorar la experiencia del usuario.
 * 
 * @see {@link SearchInstitutions} para el componente de búsqueda.
 * @see {@link Institution} para la estructura de datos de las instituciones.
 */
const ListInstitutions: React.FC = () => {
    const [institutions, setInstitutions] = useState<Institution[]>([]);

    const truncateDescription = (description: string, maxWords: number): string => {
        const words = description.split(' ');
        return words.length > maxWords ? words.slice(0, maxWords).join(' ') + '...' : description;
    };

    return (
        <div>
            <h1 className="flex text-3xl font-extrabold justify-center items-center m-4 dark:text-white">
                Establecimientos Educativos
            </h1>
            <SearchInstitutions onResults={setInstitutions} />
            {
                institutions && institutions.length > 0 ? (
                    <div className='w-full flex justify-evenly '>
                        <ul className="text-black grid grid-cols-1 mt-2 mb-4 md:grid-cols-2 lg:grid-cols-3 gap-16">
                            {institutions.map((institution) => (
                                <Card
                                    key={institution.id}
                                    className="group relative w-[300px] h-[200px] rounded-md overflow-hidden transition-shadow hover:shadow-xl"
                                >
                                    <div
                                        className="absolute inset-0 bg-cover bg-center transition-transform duration-300 group-hover:scale-105"
                                        style={{
                                            backgroundImage: `url(${institution.imagen_perfil})`,
                                        }}
                                    ></div>
                                    <div className="absolute inset-0 bg-black opacity-30 group-hover:opacity-60 transition-opacity duration-300"></div>
                                    <div className=" z-10 p-4 pt-0 text-white h-full flex flex-col justify-start items-start">
                                        <CardTitle className="text-lg font-bold">{institution.nombre}</CardTitle>
                                        <CardDescription
                                            className="text-sm text-white opacity-0 group-hover:opacity-100 transition-opacity duration-300 mt-2"
                                        >
                                            {truncateDescription(institution.descripcion, 30)}
                                        </CardDescription>
                                    </div>
                                </Card>
                            ))}
                        </ul>
                    </div>
                ) : (
                    <p>No hay instituciones</p>
                )
            }
        </div >
    );
};

export default ListInstitutions;