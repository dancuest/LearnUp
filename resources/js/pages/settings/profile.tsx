import { type BreadcrumbItem, type SharedData } from '@/types';
import { Transition } from '@headlessui/react';
import { Head, Link, useForm, usePage } from '@inertiajs/react';
import { FormEventHandler } from 'react';

import DeleteUser from '@/components/delete-user';
import HeadingSmall from '@/components/heading-small';
import InputError from '@/components/input-error';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AppLayout from '@/layouts/app-layout';
import SettingsLayout from '@/layouts/settings/layout';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Profile settings',
        href: '/settings/profile',
    },
];

interface ProfileForm {
    name: string;
    email: string;
}

/**
 * Componente `Profile` que permite a los usuarios actualizar su información de perfil.
 *
 * @param {Object} props - Propiedades del componente.
 * @param {boolean} props.mustVerifyEmail - Indica si el usuario debe verificar su correo electrónico.
 * @param {string} [props.status] - Estado opcional que indica si se ha enviado un enlace de verificación.
 *
 * @returns {JSX.Element} - Componente de configuración del perfil del usuario.
 *
 * @remarks
 * Este componente utiliza `useForm` para manejar el estado del formulario y las validaciones.
 * También incluye un formulario para actualizar el nombre y el correo electrónico del usuario,
 * y muestra un mensaje si el correo electrónico no está verificado.
 *
 * @example
 * ```tsx
 * <Profile mustVerifyEmail={true} status="verification-link-sent" />
 * ```
 *
 * @dependencies
 * - `usePage`: Hook para acceder a los datos compartidos de la página.
 * - `useForm`: Hook para manejar formularios con validaciones y envío de datos.
 * - `AppLayout`: Componente de diseño principal.
 * - `SettingsLayout`: Componente de diseño para la sección de configuración.
 * - `HeadingSmall`, `Label`, `Input`, `InputError`, `Button`, `Transition`, `DeleteUser`: Componentes reutilizables.
 */
export default function Profile({ mustVerifyEmail, status }: { mustVerifyEmail: boolean; status?: string }) {
    const { auth } = usePage<SharedData>().props;

    const { data, setData, patch, errors, processing, recentlySuccessful } = useForm<Required<ProfileForm>>({
        name: auth.user.name,
        email: auth.user.email,
    });

    const submit: FormEventHandler = (e) => {
        e.preventDefault();

        patch(route('profile.update'), {
            preserveScroll: true,
        });
    };

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Profile settings" />

            <SettingsLayout>
                <div className="space-y-6">
                    <HeadingSmall title="Profile information" description="Update your profile information" />
                    <div className='flex items-center justify-center mb-4'>
                        <img src="https://i.pinimg.com/736x/4d/84/11/4d84110ef26af739d6e0431c2310a419.jpg" alt="Perfil"
                            className='rounded-full w-40 h-40 object-cover mb-4' />
                    </div>
                    <form onSubmit={submit} className="space-y-6">
                        <div className="grid gap-2">
                            <Label htmlFor="name">Name</Label>

                            <Input
                                id="name"
                                className="mt-1 block w-full border-blue-600"
                                value={data.name}
                                onChange={(e) => setData('name', e.target.value)}
                                required
                                autoComplete="name"
                                placeholder="Full name"
                            />

                            <InputError className="mt-2" message={errors.name} />
                        </div>

                        <div className="grid gap-2">
                            <Label htmlFor="email">Email address</Label>

                            <Input
                                id="email"
                                type="email"
                                className="mt-1 block border-blue-600 w-full"
                                value={data.email}
                                onChange={(e) => setData('email', e.target.value)}
                                required
                                autoComplete="username"
                                placeholder="Email address"
                            />

                            <InputError className="mt-2" message={errors.email} />
                        </div>

                        {mustVerifyEmail && auth.user.email_verified_at === null && (
                            <div>
                                <p className="text-muted-foreground -mt-4 text-sm">
                                    Your email address is unverified.{' '}
                                    <Link
                                        href={route('verification.send')}
                                        method="post"
                                        as="button"
                                        className="text-foreground underline decoration-neutral-300 underline-offset-4 transition-colors duration-300 ease-out hover:decoration-current! dark:decoration-neutral-500"
                                    >
                                        Click here to resend the verification email.
                                    </Link>
                                </p>

                                {status === 'verification-link-sent' && (
                                    <div className="mt-2 text-sm font-medium text-green-600">
                                        A new verification link has been sent to your email address.
                                    </div>
                                )}
                            </div>
                        )}

                        <div className="flex items-center gap-4">
                            <Button disabled={processing} className='bg-blue-600'>Save</Button>

                            <Transition
                                show={recentlySuccessful}
                                enter="transition ease-in-out"
                                enterFrom="opacity-0"
                                leave="transition ease-in-out"
                                leaveTo="opacity-0"
                            >
                                <p className="text-sm text-neutral-600">Saved</p>
                            </Transition>
                        </div>
                    </form>
                </div>
                <DeleteUser />

            </SettingsLayout>
        </AppLayout>
    );
}