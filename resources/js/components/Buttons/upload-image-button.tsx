import React, { useState } from 'react';
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

    const [uploading, setUploading] = useState(false);
    const [preview, setPreview] = useState<string | null>(null);

    const handleFileChange = (e: React.ChangeEvent<HTMLInputElement>) => {
        if (e.target.files && e.target.files[0]) {
            const file = e.target.files[0];
            setData('file', file);

            // Generar una previsualización temporal
            const reader = new FileReader();
            reader.onload = () => {
                setPreview(reader.result as string);
            };
            reader.readAsDataURL(file);
        }
    };

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();

        if (!data.file) {
            console.error('Selecciona un archivo primero');
            return;
        }

        setUploading(true);

        post(route('image.store'), {
            forceFormData: true,
            onError: (errors) => {
                console.error(errors.error || 'Error al subir la imagen');
                setUploading(false);
            },
            onSuccess: () => {
                console.log('Imagen subida con éxito');
                setUploading(false);
                setPreview(null);
            },
        });
    };

    return (
        <form onSubmit={handleSubmit} style={{ display: 'flex', flexDirection: 'column', gap: '1rem', maxWidth: '300px' }}>
            {preview ? (
                <img
                    src={preview}
                    alt="Previsualización"
                    style={{
                        width: '150px',
                        height: '150px',
                        objectFit: 'cover',
                        borderRadius: '4px',
                        border: '1px solid #ccc',
                    }}
                />
            ) : (
                <div
                    style={{
                        width: '50px',
                        height: '50px',
                        display: 'flex',
                        alignItems: 'center',
                        justifyContent: 'center',
                        backgroundColor: '#f3f3f3',
                        borderRadius: '4px',
                        border: '1px solid #ccc',
                        fontSize: '0.875rem',
                        color: '#666',
                    }}
                >
                    Sin imagen
                </div>
            )}
            <div style={{ display: 'flex', alignItems: 'center', gap: '1rem' }}>
                <button
                    type="button"
                    onClick={() => document.getElementById('fileInput')?.click()}
                    style={{
                        padding: '0.75rem',
                        backgroundColor: '#007bff',
                        color: '#fff',
                        border: 'none',
                        borderRadius: '4px',
                        fontSize: '1rem',
                        cursor: 'pointer',
                        width: '120px',
                        textAlign: 'center',
                    }}
                >
                    Seleccionar Imagen
                </button>
                <input
                    id="fileInput"
                    type="file"
                    onChange={handleFileChange}
                    name="file"
                    style={{ display: 'none' }}
                />
                {errors.file && <div style={{ color: 'red', fontSize: '0.875rem' }}>{errors.file}</div>}
                <button
                    type="submit"
                    disabled={uploading}
                    style={{
                        padding: '0.75rem',
                        backgroundColor: uploading ? '#ccc' : '#007bff',
                        color: '#fff',
                        border: 'none',
                        borderRadius: '4px',
                        fontSize: '1rem',
                        cursor: uploading ? 'not-allowed' : 'pointer',
                    }}
                >
                    {uploading ? 'Subiendo...' : 'Subir Imagen'}
                </button>
                {uploading && (
                    <div style={{ display: 'flex', alignItems: 'center', gap: '0.5rem' }}>
                        <div
                            style={{
                                width: '100%',
                                backgroundColor: '#f3f3f3',
                                borderRadius: '4px',
                                overflow: 'hidden',
                                position: 'relative',
                            }}
                        >
                            <div
                                style={{
                                    width: progress ? `${progress.percentage}%` : '100%',
                                    backgroundColor: '#007bff',
                                    height: '8px',
                                    transition: 'width 0.3s ease',
                                }}
                            ></div>
                        </div>
                        {!progress && (
                            <div style={{ fontSize: '0.875rem', color: '#666', animation: 'blink 1s infinite' }}>
                                Cargando...
                            </div>
                        )}
                    </div>
                )}
            </div>
        </form>
    );
};

export default UploadImageButton;
