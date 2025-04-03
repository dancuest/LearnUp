import { Head, usePage } from '@inertiajs/react';

import AppearanceTabs from '@/components/appearance-tabs';
import HeadingSmall from '@/components/heading-small';
import { SharedData, type BreadcrumbItem } from '@/types';

import AppLayout from '@/layouts/app-layout';
import SettingsLayout from '@/layouts/settings/layout';
import UploadImageButton from '@/components/Buttons/upload-image-button';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'image upload settings',
        href: '/settings/image-upload',
    },
];

export default function Appearance() {
    const { auth } = usePage<SharedData>().props;
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="image upload" />

            <SettingsLayout>
                <div className="space-y-6">
                    <HeadingSmall title="Appearance settings" description="Update your account's appearance settings" />
                    <UploadImageButton table='users' rowId={auth.user.id} column="imagen_perfil" />
                </div>
            </SettingsLayout>
        </AppLayout>
    );
}
