import UploadImageButton from "@/components/Buttons/upload-image-button";
import { Upload } from "lucide-react";

export default function StyleGuide() {

    return (<div className="flex min-h-screen flex-col items-start p-6 text-[#1b1b18] lg:justify-start lg:p-8 dark:bg-[#0a0a0a]">
        <h1>Style Guide</h1>
        <p>This is a style guide for the application.</p>
        <h2>Colors</h2>
        <ul>
            <li className="w-min bg-[#FF5733]"> #FF5733</li>
            <li className="w-min bg-[#33FF57]"> #33FF57</li>
            <li className="w-min bg-[#3357FF]"> #3357FF</li>
        </ul>
        <h2>Typography</h2>
        <p>This is a sample paragraph to demonstrate typography.</p>
        <UploadImageButton table="users" rowId={1} column="imagen_perfil" />
    </div>)
}