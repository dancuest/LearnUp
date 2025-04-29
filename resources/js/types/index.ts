import { LucideIcon } from 'lucide-react';
import { PageProps as InertiaPageProps } from "@inertiajs/core";

export interface Auth {
    user: User;
}

export interface BreadcrumbItem {
    title: string;
    href: string;
}

export interface NavGroup {
    title: string;
    items: NavItem[];
}

export interface NavItem {
    title: string;
    url: string;
    icon?: LucideIcon | null;
    isActive?: boolean;
}

export interface SharedData {
    name: string;
    quote: { message: string; author: string };
    auth: Auth;
    [key: string]: unknown;
}

export interface User {
    id: number;
    name: string;
    email: string;
    imagen_perfil?: string;
}
export interface PageProps extends InertiaPageProps {
    auth?: {
        user?: User;
    };
}
