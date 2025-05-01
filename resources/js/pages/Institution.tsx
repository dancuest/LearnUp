import { useEffect, useState } from "react";
import axios from "axios";
import Navbar from "@/components/navbar";

interface Institution {
    id: number;
    nombre: string;
    descripcion: string;
    tipo: string;
    capacidad: number;
    capacidad_limite: boolean;
    imagen_perfil: string;
    user_id: number;
    creador?: {
        id: number;
        name: string;
        email: string;
    };
    miembros?: {
        id: number;
        name: string;
        rol: string;
        estado: string;
        estado_pago: string;
        fecha_pago: string;
    }[];
    cursos?: {
        id: number;
        nombre: string;
        descripcion: string;
    }[];
    planes?: {
        id: number;
        nombre: string;
        fecha_inicio: string;
        fecha_fin: string;
        estado: string;
        renovacion_automatica: boolean;
    }[];
    pagos?: {
        id: number;
        amount: number;
        date: string;
    }[];
}

export default function Institution({ id }: { id: number }) {
    const [institution, setInstitution] = useState<Institution | null>(null);

    useEffect(() => {
        axios
            .get(route('institution.findById', { id }))
            .then((response) => {
                setInstitution(response.data);
                console.log(response.data);
            })
            .catch((error) => console.error("Error fetching institution data:", error));
    }, [id]);

    return (
        <>
            <Navbar />
            <div className="h-full flex flex-col items-center">
                {institution ? (
                    <>
                        {/* Hero Section */}
                        <div className="w-full bg-blue-600 text-white py-10 text-center">
                            <h1 className="text-4xl font-bold">{institution.nombre}</h1>
                            <p className="mt-4 text-lg">{institution.descripcion}</p>
                        </div>

                        {/* Institution Details */}
                        <div className="w-11/12 max-w-4xl mt-10 bg-white shadow-md rounded-lg p-6">
                            <h2 className="text-2xl font-semibold mb-4">Institution Details</h2>
                            <p><strong>Type:</strong> {institution.tipo}</p>
                            <p><strong>Capacity:</strong> {institution.capacidad}</p>
                            <p><strong>Capacity Limit:</strong> {institution.capacidad_limite ? "Yes" : "No"}</p>
                            {institution.imagen_perfil && (
                                <img
                                    src={institution.imagen_perfil}
                                    alt={`${institution.nombre} Profile`}
                                    className="mt-4 w-full h-64 object-cover rounded-lg"
                                />
                            )}
                        </div>

                        {/* Members Section */}
                        {institution.miembros && institution.miembros.length > 0 && (
                            <div className="w-11/12 max-w-4xl mt-10 bg-white shadow-md rounded-lg p-6">
                                <h2 className="text-2xl font-semibold mb-4">Members</h2>
                                <ul>
                                    {institution.miembros.map((miembro) => (
                                        <li key={miembro.id} className="border-b py-2">
                                            <p><strong>Name:</strong> {miembro.name}</p>
                                            <p><strong>Role:</strong> {miembro.rol}</p>
                                            <p><strong>Status:</strong> {miembro.estado}</p>
                                        </li>
                                    ))}
                                </ul>
                            </div>
                        )}
                    </>
                ) : (
                    <p className="mt-20 text-lg">Loading institution data...</p>
                )}
            </div>
        </>
    );
}