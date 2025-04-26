import React, { useState } from 'react';
import InstitutionTarget from './InstitutionTarget'; // Import the InstitutionTarget component
import SearchInstitutions from './search-institutions';
import fondo_usuario from "../../images/fondo-usuario.jpg";
import icono from "../../images/Item.png";

interface Institution {
    id: number;
    nombre: string;
    descripcion: string;
    imagen_perfil: string;
    capacidad: number;
}

const ListInstitutions: React.FC = () => {
    const [institutions, setInstitutions] = useState<Institution[]>([]);
    const [page, setPage] = useState<number>(0);
    const [hasMore, setHasMore] = useState<boolean>(true);
    const limit = 9;

    const handlePageChange = (newPage: number) => {
        if (newPage >= 0) {
            setPage(newPage);
        }
    };

    const handleResults = (results: Institution[]) => {
        setInstitutions(results);
        setHasMore(results.length === limit);
    };

    return (
        <div>
            <h1 className="flex text-3xl font-extrabold justify-center items-center m-4 dark:text-white sm:text-4xl lg:text-5xl">
                Establecimientos Educativos
            </h1>
            <SearchInstitutions
                onResults={handleResults}
                limit={limit}
                offset={page}
            />
            {
                institutions && institutions.length > 0 ? (
                    <div className='w-full flex flex-col items-center'>
                        <ul className="text-black grid grid-cols-1 mt-2 mb-4 gap-4 md:grid-cols-2 sm:gap-16 lg:grid-cols-3">
                            {institutions.map((institution) => (
                                <InstitutionTarget
                                    key={institution.id}
                                    props={{
                                        backgroundImage: fondo_usuario,
                                        icon: institution.imagen_perfil ? institution.imagen_perfil : icono,
                                        name: institution.nombre,
                                        enrolled: institution.capacidad,
                                    }}
                                />
                            ))}
                        </ul>
                        <div className="w-full flex justify-center mt-4 mb-4">
                            <button
                                onClick={() => handlePageChange(page - 1)}
                                disabled={page === 0}
                                className="disabled:opacity-50 hover:cursor-pointer disabled:cursor-auto"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" className="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m18.75 4.5-7.5 7.5 7.5 7.5m-6-15L5.25 12l7.5 7.5" />
                                </svg>
                            </button>
                            <span className="px-4 py-2">{`${page + 1}`}</span>
                            <button
                                onClick={() => handlePageChange(page + 1)}
                                disabled={!hasMore && institutions.length < limit}
                                className="disabled:opacity-50 hover:cursor-pointer disabled:cursor-auto"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth={1.5} stroke="currentColor" className="size-6">
                                    <path strokeLinecap="round" strokeLinejoin="round" d="m5.25 4.5 7.5 7.5-7.5 7.5m6-15 7.5 7.5-7.5 7.5" />
                                </svg>
                            </button>
                        </div>
                    </div>
                ) : (
                    <p>No hay instituciones</p>
                )
            }
        </div>
    );
};

export default ListInstitutions;