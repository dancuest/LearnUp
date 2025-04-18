import React, { useState, useEffect, useRef } from 'react';
import { Input } from './ui/input';

interface Institution {
    id: number;
    nombre: string;
    descripcion: string;
    imagen_perfil: string;
}

interface SearchInstitutionsProps {
    onResults: (institutions: Institution[]) => void;
}

/**
 * Un componente funcional de React que proporciona una interfaz de búsqueda para instituciones.
 * 
 * @componente
 * @param {SearchInstitutionsProps} props - Las propiedades del componente.
 * @param {(results: Institution[]) => void} props.onResults - Función de devolución de llamada para manejar los resultados de la búsqueda.
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
 * <SearchInstitutions onResults={(results) => console.log(results)} />
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
const SearchInstitutions: React.FC<SearchInstitutionsProps> = ({ onResults }) => {
    const [search, setSearch] = useState<string>('');
    const [loading, setLoading] = useState<boolean>(false);
    const [error, setError] = useState<string | null>(null);
    const searchInputRef = useRef<HTMLInputElement>(null);

    const fetchInstitutions = async (nombre: string = '') => {
        try {
            setLoading(true);
            const response = await fetch(route('institution.findAll') + `?nombre=${nombre}`, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                },
            });

            if (!response.ok) {
                throw new Error('Failed to fetch institutions.');
            }

            const data = await response.json();
            onResults(data);
        } catch (err) {
            console.error('Error fetching institutions:', err);
            setError('Failed to fetch institutions.');
        } finally {
            setLoading(false);
        }
    };

    // Solicitud inicial al cargar el componente
    useEffect(() => {
        fetchInstitutions();
    }, []);

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
