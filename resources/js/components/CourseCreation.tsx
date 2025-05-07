import { useForm } from "@inertiajs/react";
import { Button } from "./ui/button";
import { Input } from "./ui/input";
import { Label } from '@/components/ui/label';
import Toastify from 'toastify-js';
import 'toastify-js/src/toastify.css';

interface FormCursoProps {
    [key: string]: string | undefined | number;
    nombre: string;
    descripcion: string;
    costo: number;
    max_alumnos: number;
}

interface FormCursoComponentProps {
    institucion_id: string;
}

export default function FormCurso({ institucion_id }: FormCursoComponentProps) {
    const { data, setData, post, processing, reset } = useForm<FormCursoProps>({
        nombre: '',
        descripcion: '',
        costo: 0,
        max_alumnos: 0,
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
        post(route('createCurso', { institucion_id }), {
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
                
                <h1 className="text-4xl justify-center items-center flex text-[#001C59] font-semibold">Crear Curso</h1>
                <p>Complete la información requerida para registrar un nuevo curso</p>
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
                        <Label htmlFor="descripcion">Descripción del curso:</Label>
                        <Input
                            type="text"
                            id="descripcion"
                            className="mt-1 block w-full border-blue-600"
                            placeholder="Ingrese una descripción del curso"
                            value={data.descripcion}
                            onChange={(e) => setData('descripcion', e.target.value)}
                            required
                        />
                    </div>

                    <div className="mb-4">
                        <Label htmlFor="costo">Costo del curso:</Label>
                        <div className="relative">
                            <Input
                                type="number"
                                id="costo"
                                className="mt-1 block w-full border-blue-600 pr-10"
                                placeholder="Ingrese el costo del curso"
                                value={data.costo}
                                onChange={(e) => setData('costo', parseFloat(e.target.value))}
                                required
                            />
                            <span className="absolute inset-y-0 right-3 flex items-center pointer-events-none text-gray-500">
                                $
                            </span>
                        </div>
                    </div>

                    <div className="mb-4">
                        <Label htmlFor="max_alumnos">Cantidad máxima de alumnos:</Label>
                        <Input
                            type="number"
                            id="max_alumnos"
                            className="mt-1 block w-full border-blue-600"
                            placeholder="Ingrese la cantidad máxima de alumnos"
                            value={data.max_alumnos}
                            onChange={(e) => setData('max_alumnos', parseInt(e.target.value))}
                            required
                        />
                    </div>

                    <div className="flex items-center justify-center">
                        <Button 
                            type="submit" 
                            className="bg-[#001C59] text-white "
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
