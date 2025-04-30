import { Link, usePage } from "@inertiajs/react";
import axios from "axios";
import { useEffect, useState } from "react";
import { PageProps } from "@/types";

interface InstitutionTargetProps {
    backgroundImage: string | File;
    icon: string;
    name: string;
    enrolled: number;
    id: number;
}

export default function InstitutionTarget({ props }: { props: InstitutionTargetProps }) {
    const { backgroundImage, icon, name, enrolled, id }: InstitutionTargetProps = props;
    const { props: pageProps } = usePage<PageProps>();
    const user = pageProps.auth?.user;

    const [isEnrolled, setIsEnrolled] = useState(false);
    const [totalEnrolled, setTotalEnrolled] = useState(0);
    const [isLoading, setIsLoading] = useState(true);

    useEffect(() => {
        const checkEnrollment = async () => {
            if (user?.id) {
                try {
                    const response = await axios.get(route('institution.findUser'), {
                        params: {
                            user_id: user.id,
                            institucion_id: id,
                        },
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content'),
                        },
                    });
                    setIsEnrolled(response.data.isEnrolled);
                } catch (error) {
                    console.error('Error al verificar la inscripción:', error);
                    setIsEnrolled(false);
                } finally {
                    setIsLoading(false);
                }
            } else {
                setIsLoading(false);
            }
        };

        const totalEnrolled = async () => {
            try {
                const response = await axios.get(
                    route('institution.getNumberOfStudentsByInstitution', { institucion_id: id }),
                    {
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content'),
                        },
                    }
                );
                console.log('Total de inscritos:', response.data);
                setTotalEnrolled(response.data);
            } catch (error) {
                console.error('Error al obtener el total de inscritos:', error);
                setTotalEnrolled(0);
            } finally {
                setIsLoading(false);
            }
        };

        totalEnrolled();
        checkEnrollment();
    }, [user?.id, id]);

    const ingresar = async () => {
        await axios.post(route('institution.addUser'), {
            user_id: user?.id,
            institucion_id: id,
        }, {
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content'),
                'Content-Type': 'application/json',
            },
        })
            .then(() => {
                setIsEnrolled(true);
                setTotalEnrolled((prev) => prev + 1);
            })
            .catch((error) => {
                console.error('Error al agregar el usuario:', error.response?.data?.message || error.message);
            });
    };

    if (isLoading) {
        return <></>;
    }

    return (
        <a href={`/institucion/${id}`} className="flex justify-center items-center">
            <div className="w-[300px] bg-white dark:bg-gray-700 rounded-lg overflow-hidden shadow-lg flex flex-col">
                <div
                    className="h-[80px] bg-cover bg-center"
                    style={{ backgroundImage: `url(${backgroundImage})` }}
                >
                    <div className="w-[70px] h-[70px] ml-2.5 mt-2">
                        <img
                            src={icon}
                            alt="Icono de Universidad"
                            className="w-full h-full object-cover rounded-full border-4 border-white dark:border-gray-700 shadow-md"
                        />
                    </div>
                </div>
                <div className="flex w-full h-fit flex-col items-center justify-center text-center mb-4 mt-2 px-3">
                    <h2 className="flex justify-around text-xl font-semibold text-gray-900 dark:text-gray-100">{name}</h2>
                    <p className="text-gray-700 dark:text-gray-300 text-sm">Capacidad: {enrolled}</p>
                    <p className="text-gray-700 dark:text-gray-300 text-sm">Número de Inscritos: {totalEnrolled}</p>
                    {!isEnrolled && user && (
                        <button
                            onClick={ingresar}
                            className="bg-blue-700 dark:bg-blue-600 text-white text-sm mt-2 px-6 py-2 rounded-lg shadow-md hover:bg-blue-800 dark:hover:bg-blue-700 transition">
                            Inscribirse
                        </button>
                    )}
                </div>
            </div>
        </a>
    );
}