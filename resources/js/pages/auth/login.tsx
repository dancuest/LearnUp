import { Head, useForm } from '@inertiajs/react';
import { LoaderCircle } from 'lucide-react';
import { FormEventHandler } from 'react';

import InputError from '@/components/input-error';
import TextLink from '@/components/text-link';
import { Button } from '@/components/ui/button';
import { Checkbox } from '@/components/ui/checkbox';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';

interface LoginProps {
    status: string; // Adjust the type as per your actual data
    canResetPassword: boolean;
}

export default function Login({ status, canResetPassword }: LoginProps) {
    const { data, setData, post, processing, errors, reset } = useForm<{
        email: string;
        password: string;
        remember: boolean;
    }>({
        email: '',
        password: '',
        remember: false,
    });

    const submit: FormEventHandler = (e) => {
        e.preventDefault();
        post(route('login'), {
            onFinish: () => reset('password'),
        });
    };
    

    return (
        <>
            <Head title="Iniciar Sesión" />
            <div
                className="flex min-h-screen flex-col items-center bg-contain bg-center bg-white bg-no-repeat p-6 text-[#1b1b18] lg:justify-center lg:p-8"
                style={{ backgroundImage: "url('/imagenes/background.png')" }}
            >
                {/* Logo */}
                <div className="-mt-4 text-center">
                    <img src="/imagenes/Logo.png" alt="LearnUp Logo" className="w-64 mx-auto" />
                </div>
                
                {/* Login Form */}
                <div className="bg-[#E3ECF6] p-8 rounded-2xl shadow-lg w-100 text-center">
                    <h2 className="text-xl font-bold mb-4">Iniciar Sesión</h2>
                    <form className="space-y-4" onSubmit={submit}>
                        <div className="grid gap-2 justify-items-start  ">
                            <Label className='ml-2' htmlFor="email">Correo Electrónico</Label>
                            <Input className='bg-white rounded-4xl border-2 border-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-400'
                                id="email"
                                type="email"
                                required
                                autoFocus
                                autoComplete="email"
                                value={data.email}
                                onChange={(e) => setData('email', e.target.value)}
                                placeholder="email@example.com"
                            />
                            <InputError message={errors.email} />
                        </div>
                        
                        <div className="grid gap-2 mt-10">
                            <div className="flex items-center ml-2">
                                <Label htmlFor="password">Contraseña</Label>
                                {canResetPassword && (
                                    <TextLink href={route('password.request')} className="ml-auto text-sm">
                                        ¿Olvidaste tu contraseña?
                                    </TextLink>
                                )}
                            </div>
                            <Input className='bg-white rounded-4xl border-2 border-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-400'
                                id="password"
                                type="password"
                                required
                                autoComplete="current-password"
                                value={data.password}
                                onChange={(e) => setData('password', e.target.value)}
                                placeholder="Contraseña"
                            />
                            <InputError message={errors.password} />
                        </div>
                        
                        <div className="flex items-center space-x-3">
                            <Checkbox 
                                id="remember"
                                name="remember"
                                checked={data.remember}
                                onChange={(e) => setData('remember', (e.target as HTMLInputElement).checked)}
                                className={data.remember ? 'bg-blue-500 border-blue-500' : 'bg-white border-gray-500'}
                            />
                            <Label htmlFor="remember">Recuérdame</Label>
                        </div>
                        
                        <Button type="submit" className="mt-4 w-full" disabled={processing}>
                            {processing && <LoaderCircle className="h-4 w-4 animate-spin" />}
                            Iniciar Sesión
                        </Button>
                    </form>
                    
                    <div className="text-muted-foreground text-center text-sm mt-4">
                        ¿No tienes una cuenta?{' '}
                        <TextLink href={route('register')}>
                            Regístrate
                        </TextLink>
                    </div>
                </div>
            </div>
        </>
    );
}
