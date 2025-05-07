import { useState, useEffect } from 'react';
import { useForm } from "@inertiajs/react";
import { Inertia, Method } from "@inertiajs/inertia";
import { Button } from "./ui/button";
import { Input } from "./ui/input";
import { Label } from '@/components/ui/label';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from "./ui/select";
import { Textarea } from "@headlessui/react";
import Modal from 'react-modal';
import Swal from 'sweetalert2';
import Toastify from 'toastify-js';
import 'toastify-js/src/toastify.css';

interface Curso {
    id: string;
    nombre: string;
    descripcion: string;
    institucion_id: string;
    fecha_inicio?: string;
}

interface Institucion {
    id: string;
    nombre: string;
}

interface CursosListProps {
    cursos: Curso[];
    instituciones: Institucion[];
    onCursoUpdated: () => void;
}

export default function CursosList({ cursos, instituciones, onCursoUpdated }: CursosListProps) {
    const [modalIsOpen, setModalIsOpen] = useState(false);
    const [currentCurso, setCurrentCurso] = useState<Curso | null>(null);
    
    const { data, setData, put, processing, reset } = useForm({
        nombre: '',
        descripcion: '',
        institucion_id: '',
        fecha_inicio: '',
    });

    useEffect(() => {
        if (currentCurso) {
            setData({
                nombre: currentCurso.nombre,
                descripcion: currentCurso.descripcion,
                institucion_id: currentCurso.institucion_id,
                fecha_inicio: currentCurso.fecha_inicio || '',
            });
        }
    }, [currentCurso]);

    const showToast = (message: string, isSuccess: boolean) => {
        Toastify({
            text: message,
            duration: 3000,
            close: true,
            gravity: "top",
            position: "right",
            backgroundColor: isSuccess ? "#4CAF50" : "#F44336",
            stopOnFocus: true,
        }).showToast();
    };

    const handleEdit = (curso: Curso) => {
        setCurrentCurso(curso);
        setModalIsOpen(true);
    };

    const handleDelete = (cursoId: string) => {
        Swal.fire({
            title: '¿Estás seguro?',
            text: "¡No podrás revertir esta acción!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                Inertia.visit(route('cursos.destroy', { id: cursoId }), {
                    method: 'delete' as Method,
                    onSuccess: () => {
                        showToast("Curso eliminado correctamente", true);
                        onCursoUpdated();
                    },
                    onError: () => {
                        showToast("Error al eliminar el curso", false);
                    },
                });
                
                showToast("Curso eliminado correctamente", true);
                onCursoUpdated();
            }
        });
    };

    const submitEdit = async (e: React.FormEvent) => {
        e.preventDefault();
        
        if (!currentCurso) return;
        
        put(route('cursos.update', currentCurso.id), {
            onSuccess: () => {
                showToast("Curso actualizado correctamente", true);
                setModalIsOpen(false);
                onCursoUpdated();
            },
            onError: (errors) => {
                console.error("Error al actualizar el curso:", errors);
                showToast("Error al actualizar el curso", false);
            },
        });
    };

    const closeModal = () => {
        setModalIsOpen(false);
        setCurrentCurso(null);
    };

    // Estilos para el modal
    const customStyles = {
        content: {
            top: '50%',
            left: '50%',
            right: 'auto',
            bottom: 'auto',
            marginRight: '-50%',
            transform: 'translate(-50%, -50%)',
            backgroundColor: 'white',
            borderRadius: '1rem',
            padding: '2rem',
            width: '90%',
            maxWidth: '500px',
        },
        overlay: {
            backgroundColor: 'rgba(0, 0, 0, 0.5)',
            zIndex: 1000,
        },
    };

    return (
        <div className="space-y-4">
            <h1 className="text-2xl font-bold mb-4">Cursos</h1>
            
            <div className="space-y-4">
                {cursos.map((curso) => (
                    <div key={curso.id} className="flex justify-between items-center p-4 border rounded-lg">
                        <span className="font-medium">{curso.nombre}</span>
                        <div className="space-x-2">
                            <Button 
                                variant="outline" 
                                onClick={() => handleEdit(curso)}
                                className="text-blue-600 border-blue-600"
                            >
                                Editar
                            </Button>
                            <Button 
                                variant="outline" 
                                onClick={() => handleDelete(curso.id)}
                                className="text-red-600 border-red-600"
                            >
                                Eliminar
                            </Button>
                        </div>
                    </div>
                ))}
            </div>

            <Modal
                isOpen={modalIsOpen}
                onRequestClose={closeModal}
                style={customStyles}
                contentLabel="Editar Curso"
                ariaHideApp={false}
            >
                <h2 className="text-xl font-bold mb-4">Editar Curso</h2>
                
                <form className="space-y-4" onSubmit={submitEdit}>
                    <div>
                        <Label htmlFor="nombre">Nombre del curso:</Label>
                        <Input
                            type="text"
                            id="nombre"
                            className="mt-1 block w-full border-blue-600"
                            placeholder="Introduzca el nombre del curso"
                            value={data.nombre}
                            onChange={(e) => setData('nombre', e.target.value)}
                            required
                        />
                    </div>

                    <div>
                        <Label htmlFor="descripcion">Descripción:</Label>
                        <Textarea
                            rows={3}
                            id="descripcion"
                            className="mt-1 block w-full border border-blue-600 rounded-md shadow-sm"
                            placeholder="Descripción detallada del curso"
                            value={data.descripcion}
                            onChange={(e) => setData('descripcion', e.target.value)}
                            required
                        />
                    </div>

                    <div>
                        <Label htmlFor="institucion_id">Institución:</Label>
                        <Select
                            value={data.institucion_id}
                            onValueChange={(value) => setData('institucion_id', value)}
                        >
                            <SelectTrigger className="mt-1 block w-full border-blue-600 rounded px-4 py-2">
                                <SelectValue placeholder="Seleccione una institución" />
                            </SelectTrigger>
                            <SelectContent className="bg-blue-400 border border-blue-800 rounded shadow-md shadow-blue-400">
                                {instituciones.map((institucion) => (
                                    <SelectItem 
                                        key={institucion.id} 
                                        value={institucion.id}
                                    >
                                        {institucion.nombre}
                                    </SelectItem>
                                ))}
                            </SelectContent>
                        </Select>
                    </div>

                    <div>
                        <Label htmlFor="fecha_inicio">Fecha de inicio (opcional):</Label>
                        <Input
                            type="date"
                            id="fecha_inicio"
                            className="mt-1 block w-full border-blue-600"
                            value={data.fecha_inicio}
                            onChange={(e) => setData('fecha_inicio', e.target.value)}
                        />
                    </div>

                    <div className="flex justify-end space-x-2 pt-4">
                        <Button 
                            type="button" 
                            variant="outline"
                            onClick={closeModal}
                        >
                            Cancelar
                        </Button>
                        <Button 
                            type="submit" 
                            className="bg-blue-600 text-white"
                            disabled={processing}
                        >
                            {processing ? 'Guardando...' : 'Guardar cambios'}
                        </Button>
                    </div>
                </form>
            </Modal>
        </div>
    );
}