import { Head, useForm } from '@inertiajs/react';
import { LoaderCircle } from 'lucide-react';
import { FormEventHandler } from 'react';
import Toastify from 'toastify-js';
import 'toastify-js/src/toastify.css';

import InputError from '@/components/input-error';
import TextLink from '@/components/text-link';
import { Button } from '@/components/ui/button';
import { Checkbox } from '@/components/ui/checkbox';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';

interface LoginProps {
    status: string;
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

    const showToast = (message: string, type: 'success' | 'error') => {
        Toastify({
            text: message,
            duration: 3000,
            gravity: 'top',
            position: 'right',
            backgroundColor: type === 'success' ? 'green' : 'red',
            close: true,
        }).showToast();
    };

    const submit: FormEventHandler = (e) => {
        e.preventDefault();
        post(route('login'), {
            onSuccess: () => {
                showToast('Inicio de sesión exitoso 🎉', 'success');
            },
            onError: (errors) => {
                if (errors.email || errors.password) {
                    showToast('Datos incorrectos, Inténtalo de nuevo.', 'error');
                } else {
                    showToast('Ocurrió un error inesperado.', 'error');
                }
            },
            onFinish: () => reset('password'),
        });
    };

    return (
        <>
            <Head title="Iniciar Sesión" />
            <div
                className="pages flex flex-col items-center bg-contain bg-center bg-white bg-no-repeat text-[#1b1b18] lg:justify-center "
                style={{ backgroundImage: "url('/imagenes/background.png')" }}
            >

                <img src="/imagenes/Logo.png" alt="LearnUp Logo" className="w-64" />


                <div className="bg-[#E3ECF6] p-8 rounded-2xl shadow-lg w-100 text-center -mb-25">
                    <h2 className="text-xl font-bold mb-4">Iniciar Sesión</h2>
                    <form className="space-y-4" onSubmit={submit}>
                        <div className="grid gap-2 justify-items-start">
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
                                    <TextLink href={route('password.request')} className="ml-auto text-sm text-black">
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
                                onCheckedChange={(checked) => setData('remember', !!checked)} // Use onCheckedChange for controlled behavior
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
