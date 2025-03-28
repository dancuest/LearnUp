import { Link } from "@inertiajs/react";

export default function Navbar() {
    return (
        <nav className="bg-[#0A1F56] text-white py-3 px-6 shadow-md flex items-center justify-between">
            <div className="flex items-center space-x-8">  {/* Logo */}
                <img
                    src="/imagenes/logo.png" 
                    alt="LearnUp Logo"
                    className="h-16 -mt-4 -mb-4 -ml-4"
                />

                <ul className="flex space-x-8 text-lg font-semibold">
                    <li>
                        <Link
                            href="/dashboard"
                            className="relative after:absolute after:bottom-[-3px] after:left-0 after:w-full after:h-[2px] after:bg-white after:scale-x-0 hover:after:scale-x-100 after:transition-transform after:duration-300"
                        >
                            Página Principal
                        </Link>
                    </li>
                    <li>
                        <Link
                            href="/area-personal"
                            className="relative after:absolute after:bottom-[-3px] after:left-0 after:w-full after:h-[2px] after:bg-white after:scale-x-0 hover:after:scale-x-100 after:transition-transform after:duration-300"
                        >
                            Área Personal
                        </Link>
                    </li>
                    <li>
                        <Link
                            href="/horarios"
                            className="relative after:absolute after:bottom-[-3px] after:left-0 after:w-full after:h-[2px] after:bg-white after:scale-x-0 hover:after:scale-x-100 after:transition-transform after:duration-300"
                        >
                            Horarios
                        </Link>
                    </li>
                </ul>
            </div>

            <div className="h-10 w-10 bg-gray-300 rounded-full"></div>{/* Botón de perfil */}
        </nav>
    );
}
