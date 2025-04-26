import React, { useState, useEffect, useRef } from 'react';
import { Input } from './ui/input';

interface Institution {
    id: number;
    nombre: string;
    descripcion: string;
    imagen_perfil: string;
    capacidad: number; // Add inscritos to match the Target component's requirements
}

interface SearchInstitutionsProps {
    onResults: (institutions: Institution[]) => void;
    limit: number;
    offset: number;
}

/**
 * Un componente funcional de React que proporciona una interfaz de búsqueda para instituciones.
 * 
 * @componente
 * @param {SearchInstitutionsProps} props - Las propiedades del componente.
 * @param {(results: Institution[]) => void} props.onResults - Función de devolución de llamada para manejar los resultados de la búsqueda.
 * @param {number} props.limit - Límite de resultados por página.
 * @param {number} props.offset - Desplazamiento para la paginación.
 * 
 * @returns {JSX.Element} El componente de entrada de búsqueda renderizado.
 * 
 * @notas
 * - Este componente obtiene una lista de instituciones del servidor según la consulta de búsqueda.
 * - Utiliza la API `fetch` para realizar solicitudes HTTP GET a la ruta `institution.findAll`.
 * - El campo de búsqueda se enfoca automáticamente cuando el componente se monta.
 * 
 * @ejemplo
 * ```tsx
 * <SearchInstitutions onResults={(results) => console.log(results)} limit={20} offset={0} />
 * ```
 * 
 * @interno
 * - El componente mantiene un estado interno para la consulta de búsqueda, el estado de carga y los mensajes de error.
 * - Utiliza `useEffect` para obtener instituciones en el renderizado inicial y para gestionar el enfoque del campo de entrada.
 * 
 * @dependencias
 * - Hooks de React: `useState`, `useEffect`, `useRef`.
 * - Componente personalizado `Input` para renderizar el campo de entrada de búsqueda.
 */
const SearchInstitutions: React.FC<SearchInstitutionsProps> = ({ onResults, limit, offset }) => {
    const [search, setSearch] = useState<string>('');
    const [loading, setLoading] = useState<boolean>(false);
    const [error, setError] = useState<string | null>(null);
    const searchInputRef = useRef<HTMLInputElement>(null);

    const fetchInstitutions = async (nombre: string = '') => {
        console.log('Fetching institutions with search term:', nombre);
        try {
            setLoading(true);
            const response = await fetch(
                route('institution.findAll') + `?nombre=${nombre}&limit=${limit}&offset=${offset}`,
                {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                }
            );

            if (!response.ok) {
                throw new Error('Failed to fetch institutions.');
            }

            const data = await response.json();
            onResults(data.data);
        } catch (err) {
            console.error('Error fetching institutions:', err);
            setError('Failed to fetch institutions.');
        } finally {
            setLoading(false);
        }
    };

    // Solicitud inicial al cargar el componente
    useEffect(() => {
        fetchInstitutions(search); // Pass the current search term when offset or limit changes
    }, [limit, offset, search]);

    const handleSearch = (e: React.ChangeEvent<HTMLInputElement>) => {
        const value = e.target.value;
        setSearch(value);
        fetchInstitutions(value);
    };

    useEffect(() => {
        if (searchInputRef.current) {
            searchInputRef.current.focus(); // Mantiene el foco en el cuadro de búsqueda
        }
    }, []);

    return (
        <div className="w-full flex justify-center mb-4">
            <Input
                ref={searchInputRef}
                type="text"
                value={search}
                onChange={handleSearch}
                placeholder="Buscar instituciones..."
                className="border border-blue-600 p-2 w-1/2"
            />
        </div>
    );
};

export default SearchInstitutions;
