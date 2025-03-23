import { Link } from "@inertiajs/react";
import { Button } from "@/components/ui/button";
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuTrigger,
} from "@/components/ui/dropdown-menu";

const Navbar = () => {
    return (
        <nav className="bg-blue-600 p-4 text-white">
            <div className="container mx-auto flex justify-between items-center">
                {/* Logo */}
                <Link href="/" className="text-xl font-bold">
                    LearnUp
                </Link>

                {/* Menú para pantallas grandes */}
                <div className="hidden md:flex space-x-6">
                    <Button asChild variant="ghost">
                        <Link href="/">Inicio</Link>
                    </Button>
                    <Button asChild variant="ghost">
                        <Link href="/cursos">Cursos</Link>
                    </Button>
                    <Button asChild variant="ghost">
                        <Link href="/evaluaciones">Evaluaciones</Link>
                    </Button>
                    <Button asChild variant="ghost">
                        <Link href="/mensajes">Mensajes</Link>
                    </Button>
                </div>

                {/* Menú para móviles con Dropdown */}
                <div className="md:hidden">
                    <DropdownMenu>
                        <DropdownMenuTrigger asChild>
                            <Button variant="outline">☰</Button>
                        </DropdownMenuTrigger>
                        <DropdownMenuContent align="end" className="bg-blue-700 text-white">
                            <DropdownMenuItem>
                                <Link href="/">Inicio</Link>
                            </DropdownMenuItem>
                            <DropdownMenuItem>
                                <Link href="/cursos">Cursos</Link>
                            </DropdownMenuItem>
                            <DropdownMenuItem>
                                <Link href="/evaluaciones">Evaluaciones</Link>
                            </DropdownMenuItem>
                            <DropdownMenuItem>
                                <Link href="/mensajes">Mensajes</Link>
                            </DropdownMenuItem>
                        </DropdownMenuContent>
                    </DropdownMenu>
                </div>
            </div>
        </nav>
    );
};

export default Navbar;
