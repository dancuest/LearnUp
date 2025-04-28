import { Link, usePage } from "@inertiajs/react";
import { PageProps as InertiaPageProps } from "@inertiajs/core"; // Importa la interfaz base
import { useEffect, useState } from "react";

interface NavbarProps {
    profileImage?: string;
}

interface User {
    id: number;
    name: string;
    email: string;
    imagen_perfil?: string;
}

// Extiende la interfaz PageProps de Inertia.js
interface PageProps extends InertiaPageProps {
    auth?: {
        user?: User;
    };
}

export default function Navbar() {
    const { props: pageProps } = usePage<PageProps>(); // Usa la interfaz extendida
    const user = pageProps.auth?.user; // Obtén el usuario autenticado
    const [isLoading, setIsLoading] = useState(true);

    useEffect(() => {
        setIsLoading(false); // Ya no es necesario verificar manualmente
        console.log("user", user);
    }, []);

    return (
        <nav className="bg-[#0A1F56] text-white py-3 px-6 shadow-md flex items-center justify-between">
            <div className="flex items-center space-x-8">
                {/* Logo */}
                <img
                    src="/imagenes/logo.png"
                    alt="LearnUp Logo"
                    className="h-16 -mt-4 -mb-4 -ml-4"
                />

                {/* Menú de Navegación */}
                <ul className="flex space-x-8 text-lg font-semibold">
                    <li>
                        <Link
                            href="/"
                            className="relative after:absolute after:bottom-[-3px] after:left-0 after:w-full after:h-[2px] after:bg-white after:scale-x-0 hover:after:scale-x-100 after:transition-transform after:duration-300"
                        >
                            Página Principal
                        </Link>
                    </li>

                    <li>
                        {user ? (
                            <Link
                                href="/mis-cursos"
                                className="relative after:absolute after:bottom-[-3px] after:left-0 after:w-full after:h-[2px] after:bg-white after:scale-x-0 hover:after:scale-x-100 after:transition-transform after:duration-300"
                            >
                                Area Personal
                            </Link>
                        ) : (
                            <></>
                        )}
                    </li>
                    <li>
                        {user ? (
                            <Link
                                href="/calendar"
                                className="relative after:absolute after:bottom-[-3px] after:left-0 after:w-full after:h-[2px] after:bg-white after:scale-x-0 hover:after:scale-x-100 after:transition-transform after:duration-300"
                            >
                                Calendario
                            </Link>
                        ) : (
                            <></>
                        )}
                    </li>
                </ul>
            </div>

            {/* Imagen de Perfil */}
            {user ? (
                <Link
                    href="/settings/profile"
                    className="relative after:absolute after:bottom-[-3px] after:left-0 after:w-full after:h-[2px] after:bg-white after:scale-x-0 hover:after:scale-x-100 after:transition-transform after:duration-300"
                >
                    <img
                        src={"https://s3.us-east-2.amazonaws.com/learnup.docs" + String(user.imagen_perfil)}
                        alt="Foto de perfil"
                        className="h-12 w-12 rounded-full object-cover border-2 border-white shadow-md"
                    />
                </Link>
            ) : (
                <div className="flex space-x-8">
                    <Link
                        href="/login"
                        className="relative after:absolute after:bottom-[-3px] after:left-0 after:w-full after:h-[2px] after:bg-white after:scale-x-0 hover:after:scale-x-100 after:transition-transform after:duration-300"
                    >
                        Login
                    </Link>
                    <Link
                        href="/register"
                        className="relative after:absolute after:bottom-[-3px] after:left-0 after:w-full after:h-[2px] after:bg-white after:scale-x-0 hover:after:scale-x-100 after:transition-transform after:duration-300"
                    >
                        Register
                    </Link>
                </div>
            )}
        </nav>
    );
}
