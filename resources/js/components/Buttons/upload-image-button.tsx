import React from 'react';
import { useForm } from '@inertiajs/react';

interface UploadImageProps {
    table: string;
    rowId: number;
    column: string;
}

const UploadImageButton: React.FC<UploadImageProps> = ({ table, rowId, column }) => {
    const { data, setData, post, progress, errors } = useForm({
        file: null as File | null,
        table,
        row_id: rowId,
        column,
    });

    const handleFileChange = (e: React.ChangeEvent<HTMLInputElement>) => {
        if (e.target.files && e.target.files[0]) {
            console.log('Archivo seleccionado:', e.target.files[0]);
            setData('file', e.target.files[0]);
        } else {
            console.log('No se seleccionó ningún archivo.');
        }
    };

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        console.log('Datos enviados:', data);

        post(route('image.store'), {
            forceFormData: true,
            onError: (error) => {
                console.error('Error al subir la imagen:', error);
            },
            onSuccess: () => {
                console.log('Imagen subida exitosamente.');
            },
        });
    };

    return (
        <form onSubmit={handleSubmit}>
            <input type="file" onChange={handleFileChange} />
            {progress && (
                <progress value={progress.percentage} max="100">
                    {progress.percentage}%
                </progress>
            )}
            {errors.file && <div>{errors.file}</div>}
            <button type="submit">Subir Imagen</button>
        </form>
    );
};

export default UploadImageButton;
