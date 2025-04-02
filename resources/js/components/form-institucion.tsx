import { useForm } from "@inertiajs/react";
import HeadingSmall from "./heading-small";
import { Button } from "./ui/button";
import { Input } from "./ui/input";
import { Label } from '@/components/ui/label';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from "./ui/select";

interface FormInstitucionProps {
    [key: string]: string | number;
    nombre: string;
    tipo: "publico" | "privado";
    descripcion: string;
    capacidad: number;
}

export default function FormInstitucion() {
    const { data, setData, post, processing, reset } = useForm<FormInstitucionProps>({
        nombre: '',
        tipo: 'publico',
        capacidad: 0,
        descripcion: '',
    });

    const Submit = async (e: React.FormEvent) => {
        console.log("Enviando información", { data });
        e.preventDefault();
        post(route('institution.create'), {
            onSuccess: () => {
                console.log("Información enviada exitosamente");
                reset();
            },
            onError: (e) => {
                console.log("Error al enviar la información", { data, errors: e });
            },
        });
    };

    return (
        <div className="border-b-blue-500 rounded-2xl p-6 shadow-xl">
            <div className="bg-white shadow-md space-y-4 rounded px-8 pt-6 pb-8 mb-4 w-full max-w-md">
                <div className="flex items-center justify-center mb-4">
                    <img
                        src="/imagenes/Logo.png"
                        alt="LearnUp Logo"
                        className="flex items-center justify-center h-36"
                    />
                </div>
                <HeadingSmall title="Profile information" description="Update your profile information" />
                <form className="space-y-4" onSubmit={Submit}>
                    <div className="mb-4">
                        <Label htmlFor="titulo">Nombre</Label>
                        <Input
                            type="text"
                            className="mt-1 block w-full border-blue-600"
                            id="nombre"
                            placeholder="Nombre de la Institución"
                            value={data.nombre}
                            onChange={(e) => setData('nombre', e.target.value)}
                        />
                    </div>
                    <div className="mb-4">
                        <Label htmlFor="descripcion">Descripción</Label>
                        <Input
                            type="text"
                            id="descripcion"
                            className="mt-1 block w-full border-blue-600"
                            placeholder="Descripcion"
                            value={data.descripcion || ''}
                            onChange={(e) => setData('descripcion', e.target.value)}
                        />
                    </div>
                    <div className="mb-4">
                        <Label htmlFor="tipo">Tipo</Label>
                        <Select
                            value={data.tipo ? "publico" : "privado"}
                            onValueChange={(value) => setData('tipo', value as "publico" | "privado")}
                        >
                            <SelectTrigger className="mt-1 block w-full border-blue-600 rounded px-4 py-2">
                                <SelectValue placeholder="Selecciona un tipo" />
                            </SelectTrigger>
                            <SelectContent className="bg-blue-500 border rounded shadow-amber-100">
                                <SelectItem value="publico">Público</SelectItem>
                                <SelectItem value="privado">Privado</SelectItem>
                            </SelectContent>
                        </Select>
                    </div>
                    <div className="mb-4">
                        <Label htmlFor="capacidad">Capacidad</Label>
                        <Input
                            type="number"
                            id="capacidad"
                            placeholder="Capacidad de la Institución"
                            className="mt-1 block w-full border-blue-600"
                            value={data.capacidad}
                            onChange={(e) => setData('capacidad', Number(e.target.value))}
                        />
                    </div>
                    <div className="flex items-center justify-between">
                        <Button type="submit" className="bg-blue-600" disabled={processing}>
                            Save
                        </Button>
                    </div>
                </form>
            </div>
        </div>
    );
}