import React from 'react';
import { useForm } from '@inertiajs/react';

interface DeleteImageProps {
    table: string;
    rowId: number;
    column: string;
}

const DeleteImageButton: React.FC<DeleteImageProps> = ({ table, rowId, column }) => {
    const { delete: destroy } = useForm();

    const handleDelete = () => {
        if (confirm('¿Estás seguro de que deseas eliminar esta imagen?')) {
            destroy(route('image.destroy'), {
                data: { table, row_id: rowId, column },
            });
        }
    };

    return (
        <button onClick={handleDelete} style={{ backgroundColor: 'red', color: 'white' }}>
            Eliminar Imagen
        </button>
    );
};

export default DeleteImageButton;
