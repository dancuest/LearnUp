import { useForm } from "@inertiajs/react";
import HeadingSmall from "./heading-small";
import { Button } from "./ui/button";
import { Input } from "./ui/input";
import { Label } from '@/components/ui/label';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from "./ui/select";
import { Textarea } from "@headlessui/react";
import Toastify from 'toastify-js';
import 'toastify-js/src/toastify.css';

interface FormCursoProps {
    [key: string]: string | undefined;
    nombre: string;
    descripcion: string;
    institucion_id: string;
    fecha_inicio?: string;
}

interface FormCursoComponentProps {
    instituciones: Array<{
        id: string;
        nombre: string;
    }>;
}

export default function FormCurso({ instituciones }: FormCursoComponentProps) {
    const { data, setData, post, processing, reset } = useForm<FormCursoProps>({
        nombre: '',
        descripcion: '',
        institucion_id: '',
        fecha_inicio: '',
    });

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

    const submit = async (e: React.FormEvent) => {
        e.preventDefault();
        post(route('cursos.store'), {
            onSuccess: () => {
                reset();
                showToast("Curso creado correctamente", true);
            },
            onError: (errors) => {
                console.error("Error al crear el curso:", errors);
                showToast("Error al crear el curso", false);
            },
        });
    };

    return (
        <div className="border-b-blue-500 rounded-4xl p-6 shadow-xl dark:text-white">
            <div className="shadow-md space-y-4 rounded-3xl px-8 pt-6 pb-8 mb-4 w-full max-w-md dark:bg-black">
                <HeadingSmall 
                    title="Crear nuevo curso" 
                    description="Complete la información requerida para registrar un nuevo curso" 
                />
                
                <form className="space-y-4 dark:text-white" onSubmit={submit}>
                    <div className="mb-4">
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

                    <div className="mb-4">
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

                    <div className="mb-4">
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

                    <div className="mb-4">
                        <Label htmlFor="fecha_inicio">Fecha de inicio (opcional):</Label>
                        <Input
                            type="date"
                            id="fecha_inicio"
                            className="mt-1 block w-full border-blue-600"
                            value={data.fecha_inicio}
                            onChange={(e) => setData('fecha_inicio', e.target.value)}
                        />
                    </div>

                    <div className="flex items-center justify-center">
                        <Button 
                            type="submit" 
                            className="bg-blue-600 dar"
                            variant={"ghost"}
                            disabled={processing}
                        >
                            {processing ? 'Creando...' : 'Crear curso'}
                        </Button>
                    </div>
                </form>
            </div>
        </div>
    );
}