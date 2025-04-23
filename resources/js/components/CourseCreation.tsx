import { useEffect, useState } from "react";
import { useForm } from "react-hook-form";
import Select from "react-select";
import axios from "axios";
import { toast } from "react-toastify";

export default function CrearCursoForm() {
    const { register, handleSubmit, setValue, formState: { errors } } = useForm();
    const [instituciones, setInstituciones] = useState([]);
    const [isAuthorized, setIsAuthorized] = useState(false);

    useEffect(() => {
        // Simular verificación de permisos del usuario
        const userHasPermission = true; // Cambiar lógica 
        setIsAuthorized(userHasPermission);

        axios.get("/api/instituciones")
            .then(res => {
                const opciones = res.data.map((inst: { id: number; nombre: string }) => ({
                    value: inst.id,
                    label: inst.nombre
                }));
                setInstituciones(opciones);
            })
            .catch(() => {
                toast.error("Error al cargar las instituciones");
            });
    }, []);

    const onSubmit = async (data: Record<string, any>) => {
        try {
            const response = await axios.post("/api/cursos", data);
            toast.success("Curso creado exitosamente");
        } catch (error) {
            toast.error("Hubo un error al crear el curso");
        }
    };

    if (!isAuthorized) {
        return <p className="text-center text-red-600">No tienes permisos para crear cursos.</p>;
    }

    return (
        <div className="max-w-md mx-auto p-6">
            <h1 className="text-2xl font-bold text-center text-blue-900 mb-6">Crear Curso</h1>

            <form onSubmit={handleSubmit(onSubmit)} className="space-y-4">
                <div>
                    <label className="block text-sm font-medium">Nombre del curso</label>
                    <input 
                        type="text" 
                        {...register("nombre", { required: true })} 
                        className="w-full border rounded-md p-2" 
                    />
                    {errors.nombre && <p className="text-red-500 text-sm">Este campo es obligatorio</p>}
                </div>

                <div>
                    <label className="block text-sm font-medium">Descripción</label>
                    <textarea 
                        {...register("descripcion", { required: true })} 
                        className="w-full border rounded-md p-2 h-24"
                    ></textarea>
                    {errors.descripcion && <p className="text-red-500 text-sm">Este campo es obligatorio</p>}
                </div>

                <div>
                    <label className="block text-sm font-medium">Institución</label>
                    <Select
                        options={instituciones}
                        onChange={(option: { value: number; label: string } | null) => setValue("institucionId", option?.value)}
                        placeholder="Seleccionar institución"
                    />
                    {errors.institucionId && <p className="text-red-500 text-sm">Este campo es obligatorio</p>}
                    <input 
                        type="hidden" 
                        {...register("institucionId", { required: true })}
                    />
                </div>

                <div>
                    <label className="block text-sm font-medium">Fecha de inicio (opcional)</label>
                    <input 
                        type="date" 
                        {...register("fechaInicio")} 
                        className="w-full border rounded-md p-2"
                    />
                </div>

                <button
                    type="submit"
                    className="w-full bg-blue-900 text-white py-2 rounded-md hover:bg-blue-950 transition"
                >
                    Crear
                </button>
            </form>
        </div>
    );
}
