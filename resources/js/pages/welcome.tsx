import { type SharedData } from '@/types';
import { Head, Link, usePage } from '@inertiajs/react';
import logo from '@../../public/build/assets/Logo.png';
import background from '@../../public/build/assets/background.png';


export default function Welcome() {
    const { auth } = usePage<SharedData>().props;

    return (
        <>
            <Head title="Welcome">
                <link rel="preconnect" href="https://fonts.bunny.net" />
                <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
            </Head>
            <div
                className="flex min-h-screen flex-col items-center bg-contain  bg-center bg-white bg-no-repeat p-6 text-[#1b1b18] lg:justify-center lg:p-8"
                style={{ backgroundImage: "url('/build/assets/background.png')" }}
            >                   
                {/* Logo */}
                <div className="mb-6 text-center">
                    <img src="/build/assets/Logo.png" alt="LearnUp Logo" className="w-64 mx-auto" />

                </div>
                
                {/* Login Form */}
                <div className="bg-[#E3ECF6] p-8 rounded-2xl shadow-lg w-96 text-center">
                    <h2 className="text-xl font-bold mb-4">Iniciar Sesión</h2>
                    <form className="space-y-4">
                        <input
                            type="text"
                            placeholder="Usuario"
                            className="w-full p-3 bg-white rounded-4xl border-2 border-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-400"
                        />
                        <input
                            type="password"
                            placeholder="Contraseña"
                            className="w-full p-3 bg-white rounded-4xl border-2 border-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-400"
                        />
                        <button
                            type="submit"
                            className="w-70 bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700 transition"
                        >
                            Entrar
                        </button>
                    </form>
                    
                    <button
                            type="submit"
                            className="mt-4 w-40 bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700 transition"
                        >
                            Registrarse
                        </button>
                    <div className="mt-4">
                        <Link href={route('password.request')} className="text-blue-600 hover:underline">Olvidé mi contraseña</Link>
                    </div>
                </div>
            </div>
        </>
    );
}
