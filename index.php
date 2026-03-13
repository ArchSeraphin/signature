<?php
session_start();

// --- CONFIGURATION ---
$MOT_DE_PASSE = "voilavoila"; 

// LOGOUT
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: index.php");
    exit;
}

// LOGIN CHECK
$error = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['password'])) {
    if ($_POST['password'] === $MOT_DE_PASSE) {
        $_SESSION['logged_in'] = true;
        header("Location: index.php");
        exit;
    } else {
        $error = "Mot de passe incorrect";
    }
}

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Voilà Voilà</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; background-color: #f3f4f6; }</style>
</head>
<body class="flex h-screen items-center justify-center">
    <div class="bg-white p-10 rounded-2xl shadow-xl w-full max-w-sm text-center">
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-blue-600 font-sans" style="font-family: 'Courier New', Courier, monospace;">voilà voilà</h1>
        </div>
        <h2 class="text-xl font-bold text-gray-800 mb-6">Signature Manager</h2>
        <form method="POST">
            <div class="mb-4">
                <input type="password" name="password" placeholder="Mot de passe" 
                       class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent transition" autofocus>
            </div>
            <?php if($error): ?>
                <p class="text-red-500 text-sm mb-4"><?php echo $error; ?></p>
            <?php endif; ?>
            <button type="submit" class="w-full bg-black text-white font-bold py-3 rounded-lg hover:bg-gray-800 transition">Se connecter</button>
        </form>
    </div>
</body>
</html>
<?php exit; } ?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voila Voila - Signature Manager</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f3f4f6; }
        #preview-container table { border-collapse: collapse; }
        .input-group label { display: block; font-size: 0.875rem; font-weight: 600; color: #374151; margin-bottom: 0.25rem; }
        .input-group input, .input-group select, .input-group textarea { width: 100%; border: 1px solid #d1d5db; border-radius: 0.375rem; padding: 0.5rem; font-size: 0.875rem; color: #111827; }
        
        /* Style Slider */
        input[type=range] { width: 100%; height: 6px; background: #e5e7eb; border-radius: 5px; outline: none; -webkit-appearance: none; }
        input[type=range]::-webkit-slider-thumb { -webkit-appearance: none; width: 18px; height: 18px; border-radius: 50%; background: #2563eb; cursor: pointer; transition: background .15s ease-in-out; }
        input[type=range]::-webkit-slider-thumb:hover { background: #1d4ed8; }
        
        .link-item { background: #f9fafb; border: 1px solid #e5e7eb; padding: 10px; border-radius: 6px; margin-bottom: 8px; position: relative; }
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 3px; }
    </style>
</head>
<body class="flex h-screen overflow-hidden">

    <aside class="w-80 bg-white border-r border-gray-200 flex flex-col justify-between hidden md:flex shrink-0 z-40">
        <div>
            <div class="p-6">
                <h1 class="text-2xl font-bold text-blue-600 font-sans" style="font-family: 'Courier New', Courier, monospace;">voilà voilà</h1>
                <p class="text-xs text-gray-500 uppercase tracking-wider mt-1">Signature Manager</p>
            </div>
            <div class="px-4 mb-6">
                <button onclick="createNewProject()" class="w-full bg-gray-900 text-white font-bold py-3 px-4 rounded hover:bg-gray-800 transition shadow-lg">+ NOUVEAU PROJET</button>
            </div>
            <div class="px-4 pb-2">
                <h3 class="text-xs font-bold text-gray-400 uppercase">Projets existants</h3>
            </div>
            <nav id="project-list" class="px-4 space-y-1 overflow-y-auto h-[calc(100vh-250px)]">
                <div class="text-sm text-gray-400 italic">Chargement...</div>
            </nav>
        </div>
        <div class="p-6 border-t border-gray-100">
            <a href="?logout=true" class="text-red-500 text-sm font-medium hover:underline block text-center">Déconnexion</a>
        </div>
    </aside>

    <main class="flex-1 overflow-y-auto relative h-full">
        <div class="px-8 pb-20">

            <div class="sticky top-0 z-30 bg-[#f3f4f6] pt-8 pb-4">
                <div class="flex justify-between items-center bg-indigo-50 p-4 rounded-xl border border-indigo-200 shadow-md backdrop-blur-sm bg-opacity-90">
                    <div>
                        <h3 class="text-indigo-800 font-bold text-lg leading-tight">Projet en cours</h3>
                        <p id="status-msg" class="text-indigo-600 text-xs mt-0.5">Modifications non enregistrées</p>
                    </div>
                    <div class="flex items-center space-x-3">
                        <button onclick="saveProject()" class="text-sm bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700 transition shadow font-bold flex items-center">💾 Sauvegarder</button>
                    </div>
                </div>
            </div>

            <div class="max-w-lg mx-auto space-y-6 mt-2">
                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
                    <h2 class="text-lg font-bold text-gray-800 mb-4">Configuration Projet</h2>
                    <div class="input-group">
                        <label>ID Unique (Slug)</label>
                        <input type="text" id="slug" placeholder="ex: nicolas-gallet" class="bg-gray-50 font-mono" oninput="sanitizeSlug(this)">
                    </div>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100 border-l-4 border-l-blue-500">
                    <h2 class="text-lg font-bold text-gray-800 mb-4">Style & Apparence</h2>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="input-group col-span-2">
                            <label>Choisir le Template</label>
                            <select id="styleTemplate" onchange="updateSignature()">
                                <option value="classic">Style 1 : Classique (Barre Latérale)</option>
                                <option value="horizontal">Style 2 : Horizontal (Épuré)</option>
                                <option value="header">Style 3 : Vertical (Logo au-dessus)</option>
                            </select>
                        </div>
                        
                        <div class="input-group col-span-2">
                            <div class="flex justify-between items-center mb-1">
                                <label class="mb-0">Taille du Logo</label>
                                <span id="logoWidthDisplay" class="text-xs font-bold text-blue-600 bg-blue-100 px-2 py-1 rounded">100px</span>
                            </div>
                            <input type="range" id="logoWidth" min="50" max="350" value="100" class="w-full" oninput="updateSignature()">
                        </div>

                        <div class="input-group">
                            <label>Couleur Principale</label>
                            <div class="flex items-center space-x-2">
                                <input type="color" id="primaryColor" value="#000000" class="h-10 w-12 p-0 border-0 rounded cursor-pointer" oninput="updateSignature()">
                                <input type="text" id="primaryColorText" value="#000000" class="flex-1" oninput="document.getElementById('primaryColor').value = this.value; updateSignature()">
                            </div>
                        </div>
                        <div class="input-group">
                            <label>Taille police (px)</label>
                            <input type="number" id="fontSize" value="14" min="10" max="20" oninput="updateSignature()">
                        </div>
                    </div>
                    <div class="flex items-center mt-4 pt-4 border-t border-gray-100">
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" id="showBorder" class="sr-only peer" onchange="updateSignature()">
                            <div class="w-9 h-5 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-blue-600"></div>
                            <span class="ml-3 text-sm font-semibold text-gray-700">Afficher le cadre autour de la signature</span>
                        </label>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
                    <h2 class="text-lg font-bold text-gray-800 mb-4">Identité</h2>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="input-group">
                            <label>Prénom & Nom</label>
                            <input type="text" id="name" placeholder="Ex: Jean Dupont" oninput="updateSignature()">
                        </div>
                        <div class="input-group">
                            <label>Poste / Fonction</label>
                            <input type="text" id="job" placeholder="Ex: Chef de projet" oninput="updateSignature()">
                        </div>
                        <div class="input-group col-span-2">
                            <label>Texte libre / Slogan (Multi-lignes)</label>
                            <textarea id="tagline" rows="3" placeholder="Ex: Service Comptabilité
il/lui" class="w-full" oninput="updateSignature()"></textarea>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
                    <h2 class="text-lg font-bold text-gray-800 mb-4">Coordonnées</h2>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="input-group">
                            <label>Email</label>
                            <input type="email" id="email" oninput="updateSignature()">
                        </div>
                        <div class="input-group">
                            <label>Téléphone</label>
                            <input type="text" id="phone" oninput="updateSignature()">
                        </div>
                        <div class="input-group col-span-2">
                            <label>Adresse Postale</label>
                            <input type="text" id="address" placeholder="Ex: 12 Rue de la Paix, 75000 Paris" oninput="updateSignature()">
                        </div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
                    <h2 class="text-lg font-bold text-gray-800 mb-4">Entreprise & Logo</h2>
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div class="input-group">
                            <label>Nom de l'entreprise</label>
                            <input type="text" id="company" placeholder="Voila Voila" oninput="updateSignature()">
                        </div>
                        <div class="input-group">
                            <label>Site Web</label>
                            <input type="text" id="website" placeholder="www.voilavoila.com" oninput="updateSignature()">
                        </div>
                    </div>
                    <div class="input-group p-4 bg-gray-50 border border-dashed border-gray-300 rounded text-center mb-4">
                        <label class="mb-2 cursor-pointer text-blue-600 hover:text-blue-800 font-medium">
                            📤 Cliquez pour uploader le Logo
                            <input type="file" id="logoInput" class="hidden" accept="image/*" onchange="uploadLogo()">
                        </label>
                        <p class="text-xs text-gray-400">Format: PNG ou JPG.</p>
                        <input type="hidden" id="logoUrl">
                        <div id="logoPreview" class="mt-2 h-6 text-sm text-green-600 font-bold"></div>
                    </div>
                    
                    <div class="input-group pt-4 border-t border-gray-100">
                        <label class="flex items-center text-yellow-600 font-bold text-sm mb-1">
                            <span class="mr-2">⭐</span> Lien Avis Google
                        </label>
                        <input type="text" id="googleReviewUrl" placeholder="https://g.page/r/..." class="border-yellow-300 focus:border-yellow-500 focus:ring-yellow-200" oninput="updateSignature()">
                        <p class="text-xs text-gray-400 mt-1">Laissez vide si vous ne voulez pas afficher le bouton.</p>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-lg font-bold text-gray-800">Réseaux Sociaux (Icones)</h2>
                        <button onclick="addCustomLink()" class="text-xs bg-blue-100 text-blue-700 px-3 py-1.5 rounded-full font-bold hover:bg-blue-200">+ Ajouter</button>
                    </div>
                    <div id="links-list" class="space-y-2"></div>
                </div>
            </div>
        </div>
    </main>

    <aside class="w-[600px] bg-gray-200 border-l border-gray-300 flex flex-col hidden lg:flex shrink-0">
        <div class="p-4 border-b border-gray-300 bg-gray-100 text-center">
            <h3 class="text-xs font-bold text-gray-500 uppercase">Simulation d'un Email</h3>
        </div>
        
        <div class="flex-1 flex flex-col p-6 overflow-auto">
            <div class="bg-white rounded-lg shadow-2xl overflow-hidden border border-gray-300 w-full flex flex-col">
                <div class="bg-gray-100 px-4 py-3 border-b border-gray-200 flex items-center gap-2">
                    <div class="w-3 h-3 rounded-full bg-red-400 border border-red-500"></div>
                    <div class="w-3 h-3 rounded-full bg-yellow-400 border border-yellow-500"></div>
                    <div class="w-3 h-3 rounded-full bg-green-400 border border-green-500"></div>
                </div>
                <div class="px-6 py-4 border-b border-gray-50">
                    <div class="text-xs text-gray-400 font-bold uppercase tracking-wider mb-2">Nouveau Message</div>
                    <div class="text-sm text-gray-700 mb-1"><strong class="text-gray-900">À :</strong> client@exemple.com</div>
                    <div class="text-sm text-gray-700"><strong class="text-gray-900">Objet :</strong> Proposition commerciale - Projet X</div>
                </div>
                
                <div class="p-8 bg-white flex-1 overflow-auto">
                    <p class="text-sm text-gray-600 mb-4 font-sans leading-relaxed">Bonjour,</p>
                    <p class="text-sm text-gray-600 mb-6 font-sans leading-relaxed">Voici la proposition finale comme convenu. N'hésitez pas à revenir vers moi si vous avez des questions.</p>
                    <p class="text-sm text-gray-600 mb-8 font-sans leading-relaxed">Bien cordialement,</p>

                    <div id="preview-output" class="w-full"></div>
                </div>
            </div>
        </div>

        <div class="p-6 bg-white border-t border-gray-200">
            <button onclick="copyToClipboard()" class="w-full bg-blue-600 text-white font-bold py-4 rounded-lg hover:bg-blue-700 transition shadow-lg text-lg">📋 Copier la signature</button>
            <p class="text-xs text-center text-gray-400 mt-2">Compatible Outlook, Gmail, Apple Mail.</p>
        </div>
    </aside>

    <script>
        const ICONS = {
            linkedin: "https://img.icons8.com/ios-filled/50/ffffff/linkedin.png",
            instagram: "https://img.icons8.com/ios-filled/50/ffffff/instagram-new.png",
            facebook: "https://img.icons8.com/ios-filled/50/ffffff/facebook-f.png",
            web: "https://img.icons8.com/ios-filled/50/ffffff/internet.png",
            calendar: "https://img.icons8.com/ios-filled/50/ffffff/calendar.png",
            other: "https://img.icons8.com/ios-filled/50/ffffff/link.png",
            
            // Infos (noires)
            email: "https://cdn-icons-png.flaticon.com/512/542/542689.png",
            phone: "https://cdn-icons-png.flaticon.com/512/455/455705.png",
            address: "https://cdn-icons-png.flaticon.com/512/535/535239.png",
            web_black: "https://cdn-icons-png.flaticon.com/512/1006/1006771.png"
        };

        let customLinks = [];

        async function fetchProjects() {
            const listEl = document.getElementById('project-list');
            listEl.innerHTML = '<div class="text-sm text-gray-400">Chargement...</div>';
            try {
                const res = await fetch('api.php?action=list');
                if(res.status === 403) { window.location.reload(); return; }
                const projects = await res.json();
                listEl.innerHTML = '';
                if(projects.length === 0) listEl.innerHTML = '<div class="text-sm p-2 text-gray-400">Aucun projet</div>';
                projects.forEach(p => {
                    const div = document.createElement('div');
                    div.className = 'cursor-pointer p-2 hover:bg-gray-100 rounded group transition';
                    div.onclick = () => loadProject(p.slug);
                    div.innerHTML = `<div class="font-bold text-gray-700 text-sm group-hover:text-blue-600">${p.name || 'Sans nom'}</div><div class="text-xs text-gray-400 truncate">${p.job || p.slug}</div>`;
                    listEl.appendChild(div);
                });
            } catch (e) { listEl.innerHTML = '<div class="text-red-500 text-xs">Erreur serveur</div>'; }
        }

        async function saveProject() {
            const slug = document.getElementById('slug').value;
            if(!slug) { alert("⚠️ Ajoutez un ID Unique (Slug) avant de sauvegarder."); return; }
            const btn = document.querySelector('button[onclick="saveProject()"]');
            const originalText = btn.innerHTML;
            btn.innerHTML = "⏳ ...";
            const data = getFormData();
            data.customLinks = customLinks;
            data.slug = slug;
            try {
                const res = await fetch('api.php?action=save', { method: 'POST', headers: {'Content-Type': 'application/json'}, body: JSON.stringify(data) });
                const result = await res.json();
                if(result.success) { document.getElementById('status-msg').innerText = "✅ Sauvegardé : " + new Date().toLocaleTimeString(); fetchProjects(); } 
                else { alert('Erreur: ' + result.error); }
            } catch(e) { alert("Erreur connexion"); }
            btn.innerHTML = originalText;
        }

        async function loadProject(slug) {
            try {
                const res = await fetch(`api.php?action=load&slug=${slug}`);
                const data = await res.json();
                if(data.error) { alert("Introuvable"); return; }
                document.getElementById('slug').value = slug;
                if(data.template) document.getElementById('styleTemplate').value = data.template;
                
                document.getElementById('name').value = data.name || '';
                document.getElementById('job').value = data.job || '';
                document.getElementById('tagline').value = data.tagline || '';
                document.getElementById('email').value = data.email || '';
                document.getElementById('phone').value = data.phone || '';
                document.getElementById('address').value = data.address || '';
                document.getElementById('company').value = data.company || '';
                document.getElementById('website').value = data.website || '';
                document.getElementById('logoUrl').value = data.logoUrl || '';
                document.getElementById('logoPreview').innerText = data.logoUrl ? "✅ Logo chargé" : "";
                document.getElementById('primaryColor').value = data.primaryColor || '#000000';
                document.getElementById('primaryColorText').value = data.primaryColor || '#000000';
                document.getElementById('fontSize').value = data.fontSize || 14;
                document.getElementById('logoWidth').value = data.logoWidth || 100;
                document.getElementById('googleReviewUrl').value = data.googleReviewUrl || '';
                document.getElementById('showBorder').checked = data.showBorder || false;

                customLinks = data.customLinks || [];
                renderLinkInputs(); updateSignature();
                document.getElementById('status-msg').innerText = "Projet chargé : " + slug;
            } catch(e) {}
        }

        async function uploadLogo() {
            const slug = document.getElementById('slug').value;
            if(!slug) { alert("Définissez d'abord un 'ID Unique' pour créer le dossier."); return; }
            const fileInput = document.getElementById('logoInput');
            if(!fileInput.files[0]) return;
            const formData = new FormData();
            formData.append('logo_file', fileInput.files[0]);
            formData.append('slug', slug);
            document.getElementById('logoPreview').innerText = "⏳ Upload...";
            try {
                const res = await fetch('api.php?action=upload_logo', { method: 'POST', body: formData });
                const result = await res.json();
                if(result.url) { document.getElementById('logoUrl').value = result.url; document.getElementById('logoPreview').innerText = "✅ Réussi"; updateSignature(); } 
                else { alert("Erreur upload"); }
            } catch(e) { alert("Erreur réseau"); }
        }

        function sanitizeSlug(input) { input.value = input.value.replace(/[^a-z0-9-]/g, '').toLowerCase(); }
        function createNewProject() { resetForm(); document.getElementById('slug').value = ""; document.getElementById('status-msg').innerText = "Nouveau projet"; }
        function addCustomLink(type = 'web', label = '', url = '') { customLinks.push({ id: Date.now(), type, label, url }); renderLinkInputs(); updateSignature(); }
        function removeLink(id) { customLinks = customLinks.filter(l => l.id !== id); renderLinkInputs(); updateSignature(); }
        function updateLinkData(id, field, value) { const link = customLinks.find(l => l.id === id); if(link) { link[field] = value; updateSignature(); } }

        function renderLinkInputs() {
            const container = document.getElementById('links-list'); container.innerHTML = '';
            customLinks.forEach(link => {
                const div = document.createElement('div');
                div.className = 'link-item grid grid-cols-12 gap-2 items-center';
                div.innerHTML = `<div class="col-span-4"><select onchange="updateLinkData(${link.id}, 'type', this.value)" class="w-full border p-1 rounded text-sm bg-white"><option value="none" ${link.type === 'none' ? 'selected' : ''}>Sans icône</option><option value="web" ${link.type === 'web' ? 'selected' : ''}>Site Web</option><option value="linkedin" ${link.type === 'linkedin' ? 'selected' : ''}>LinkedIn</option><option value="instagram" ${link.type === 'instagram' ? 'selected' : ''}>Instagram</option><option value="facebook" ${link.type === 'facebook' ? 'selected' : ''}>Facebook</option><option value="calendar" ${link.type === 'calendar' ? 'selected' : ''}>Calendrier</option></select></div><div class="col-span-7"><input type="text" value="${link.url}" placeholder="URL du profil" oninput="updateLinkData(${link.id}, 'url', this.value)" class="w-full border p-1 rounded text-sm"></div><div class="col-span-1 text-right"><span onclick="removeLink(${link.id})" class="text-red-500 cursor-pointer text-lg font-bold hover:text-red-700">×</span></div>`;
                container.appendChild(div);
            });
        }

        // --- ICONES GENERATOR (HEIGHT 28px) ---
        function generateIconsHTML(data) {
            if (customLinks.length === 0) return '';
            let iconsCells = '';
            customLinks.forEach(link => {
                const iconUrl = ICONS[link.type] || ICONS.other;
                let linkHref = link.url || '';
                if(linkHref && !linkHref.match(/^https?:\/\//)) { linkHref = 'https://' + linkHref; }
                if(link.url) {
                    iconsCells += `
                    <td width="30" align="center" valign="middle">
                        <table cellpadding="0" cellspacing="0" border="0" width="28">
                            <tr>
                                <td bgcolor="${data.primaryColor}" width="28" height="28" align="center" valign="middle" style="background-color: ${data.primaryColor}; border-radius: 4px; width: 28px; height: 28px;">
                                    <a href="${linkHref}" target="_blank" style="text-decoration: none; display: block; line-height: 0;">
                                        <img src="${iconUrl}" width="16" height="16" style="width: 16px; height: 16px; display: inline-block; border: 0;">
                                    </a>
                                </td>
                            </tr>
                        </table>
                    </td>`;
                }
            });
            return `<table cellpadding="0" cellspacing="0" border="0" style="margin-top: 10px;"><tr>${iconsCells}</tr></table>`;
        }

        function generateHTML(data) {
            let finalLogoUrl = data.logoUrl;
            if (finalLogoUrl && !finalLogoUrl.startsWith('http')) { finalLogoUrl = window.location.origin + window.location.pathname.replace('index.php', '') + finalLogoUrl; }
            
            const iconsHtml = generateIconsHTML(data);
            const commonStyles = `font-family: Arial, sans-serif; font-size: ${data.fontSize}px; line-height: 1.4; color: #333333;`;
            const taglineHtml = data.tagline ? data.tagline.replace(/\n/g, '<br>') : '';
            let webHref = data.website || '';
            if(webHref && !webHref.match(/^https?:\/\//)) { webHref = 'https://' + webHref; }
            const logoW = data.logoWidth || 100;
            const mapUrl = 'https://www.google.com/maps/search/?api=1&query=' + encodeURIComponent(data.address || '');

            const iconEmailImg = `<img src="${ICONS.email}" width="14" height="14" style="vertical-align:middle; width:14px; margin-right:5px; display:inline-block;" alt="e:">`;
            const iconPhoneImg = `<img src="${ICONS.phone}" width="14" height="14" style="vertical-align:middle; width:14px; margin-right:5px; display:inline-block;" alt="t:">`;
            const iconWebImg = `<img src="${ICONS.web_black}" width="14" height="14" style="vertical-align:middle; width:14px; margin-right:5px; display:inline-block;" alt="w:">`;
            const iconAddrImg = `<img src="${ICONS.address}" width="14" height="14" style="vertical-align:middle; width:14px; margin-right:5px; display:inline-block;" alt="a:">`;

            // BOUTON AVIS (HEIGHT 28px)
            let reviewBtnHtml = '';
            if (data.googleReviewUrl) {
                let reviewHref = data.googleReviewUrl;
                if(!reviewHref.match(/^https?:\/\//)) { reviewHref = 'https://' + reviewHref; }
                reviewBtnHtml = `
                <table cellpadding="0" cellspacing="0" border="0" style="margin-top: 10px;">
                    <tr>
                        <td height="28" bgcolor="${data.primaryColor}" style="height: 28px; background-color: ${data.primaryColor}; border-radius: 4px; padding: 0 12px; vertical-align: middle;">
                            <a href="${reviewHref}" target="_blank" style="color: #ffffff; text-decoration: none; font-weight: bold; font-size: 12px; font-family: Arial, sans-serif; display: block; line-height: 28px;">
                                ⭐ Laissez un avis
                            </a>
                        </td>
                    </tr>
                </table>`;
            }

            let innerContent = "";

            if (data.template === 'classic') {
                innerContent = `
                <table cellpadding="0" cellspacing="0" border="0" style="${commonStyles} width: 100%;">
                    <tr>
                        ${finalLogoUrl ? `<td valign="middle" style="padding-right: 15px; width: ${logoW}px;"><img src="${finalLogoUrl}" alt="Logo" width="${logoW}" style="width: ${logoW}px; border-radius: 4px; display: block;"></td>` : ''}
                        <td width="2" valign="middle" style="padding-right: 15px;">
                            <div style="width: 2px; height: 100px; background-color: ${data.primaryColor};"></div>
                        </td>
                        <td valign="middle">
                            <div style="font-weight: bold; font-size: ${parseInt(data.fontSize) + 4}px; color: #000000; margin-bottom: 2px;">${data.name}</div>
                            <div style="color: ${data.primaryColor}; font-weight: bold; margin-bottom: 6px;">${data.job} ${data.company ? '| ' + data.company : ''}</div>
                            ${taglineHtml ? `<div style="font-size: ${parseInt(data.fontSize) - 1}px; color: #666; margin-bottom: 8px; font-style: italic;">${taglineHtml}</div>` : '<div style="margin-bottom: 8px;"></div>'}
                            
                            <table cellpadding="0" cellspacing="0" border="0">
                                ${data.email ? `<tr><td width="20" valign="middle" style="padding-bottom:3px;">${iconEmailImg}</td><td valign="middle" style="padding-bottom:3px;"><a href="mailto:${data.email}" style="color:#333;text-decoration:none;">${data.email}</a></td></tr>` : ''}
                                ${data.phone ? `<tr><td width="20" valign="middle" style="padding-bottom:3px;">${iconPhoneImg}</td><td valign="middle" style="padding-bottom:3px;"><a href="tel:${data.phone}" style="color:#333;text-decoration:none;">${data.phone}</a></td></tr>` : ''}
                                ${data.address ? `<tr><td width="20" valign="middle" style="padding-bottom:3px;">${iconAddrImg}</td><td valign="middle" style="padding-bottom:3px;"><a href="${mapUrl}" target="_blank" style="color:#333;text-decoration:none;">${data.address}</a></td></tr>` : ''}
                                ${data.website ? `<tr><td width="20" valign="middle" style="padding-bottom:2px;">${iconWebImg}</td><td valign="middle" style="padding-bottom:2px;"><a href="${webHref}" style="color:#333;text-decoration:none;">${data.website.replace(/^https?:\/\//, '')}</a></td></tr>` : ''}
                            </table>
                            
                            <table cellpadding="0" cellspacing="0" border="0">
                                <tr>
                                    <td valign="middle" style="padding-right: 15px;">${iconsHtml}</td>
                                    <td valign="middle">${reviewBtnHtml}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>`;
            }

            if (data.template === 'horizontal') {
                
                let infoItems = [];
                if(data.email) infoItems.push(`<span style="white-space:nowrap; display:inline-block; margin-right:15px; margin-bottom:4px;">${iconEmailImg} <a href="mailto:${data.email}" style="color:#333;text-decoration:none;">${data.email}</a></span>`);
                if(data.phone) infoItems.push(`<span style="white-space:nowrap; display:inline-block; margin-right:15px; margin-bottom:4px;">${iconPhoneImg} <a href="tel:${data.phone}" style="color:#333;text-decoration:none;">${data.phone}</a></span>`);
                if(data.website) infoItems.push(`<span style="white-space:nowrap; display:inline-block; margin-right:15px; margin-bottom:4px;">${iconWebImg} <a href="${webHref}" style="color:#333;text-decoration:none;">${data.website.replace(/^https?:\/\//, '')}</a></span>`);
                if(data.address) infoItems.push(`<span style="white-space:nowrap; display:inline-block; margin-bottom:4px;">${iconAddrImg} <a href="${mapUrl}" target="_blank" style="color:#333;text-decoration:none;">${data.address}</a></span>`);
                
                const separator = ''; // PLUS DE SEPARATEUR | (Utilise le margin-right des spans)
                const infoBlock = infoItems.join(separator);

                innerContent = `
                <table width="100%" cellpadding="0" cellspacing="0" border="0" style="${commonStyles} width: 100%;">
                    <tr>
                        ${finalLogoUrl ? `<td valign="middle" style="padding-right: 20px; width: ${logoW}px;"><img src="${finalLogoUrl}" alt="Logo" width="${logoW}" style="width: ${logoW}px; border-radius: 50%; display: block;"></td>` : ''}
                        <td valign="middle">
                            <div style="font-weight: bold; font-size: ${parseInt(data.fontSize) + 4}px; color: #000000;">${data.name}</div>
                            <div style="font-size: ${parseInt(data.fontSize)}px; color: #555; margin-bottom: 2px;">${data.job} @ ${data.company}</div>
                            ${taglineHtml ? `<div style="font-size: ${parseInt(data.fontSize) - 2}px; color: #888;">${taglineHtml}</div>` : ''}
                            
                            <div style="border-bottom: 1px solid ${data.primaryColor}; width: 100%; margin: 8px 0;"></div>
                            
                            <div style="line-height: 1.6; width: 100%;">
                                ${infoBlock}
                            </div>
                            
                            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-top: 5px;">
                                <tr>
                                    <td align="left" valign="middle">${iconsHtml}</td>
                                    <td align="right" valign="middle">${reviewBtnHtml}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>`;
            }

            if (data.template === 'header') {
                innerContent = `
                <table cellpadding="0" cellspacing="0" border="0" style="${commonStyles} width: 100%;">
                    ${finalLogoUrl ? `<tr><td style="padding-bottom: 15px;"><img src="${finalLogoUrl}" alt="Logo" width="${logoW}" style="width: ${logoW}px; display: block;"></td></tr>` : ''}
                    <tr>
                        <td style="border-left: 4px solid ${data.primaryColor}; padding-left: 15px;">
                             <div style="font-weight: bold; font-size: ${parseInt(data.fontSize) + 6}px; color: #000000;">${data.name}</div>
                             <div style="color: ${data.primaryColor}; font-weight: bold; font-size: ${data.fontSize}px; text-transform: uppercase;">${data.job}</div>
                             ${taglineHtml ? `<div style="font-size: ${parseInt(data.fontSize) - 2}px; color: #666; margin-bottom: 12px; margin-top:2px;">${taglineHtml}</div>` : '<div style="margin-bottom:12px;"></div>'}
                             
                             <table cellpadding="0" cellspacing="0" border="0">
                                ${data.email ? `<tr><td width="20" valign="middle" style="padding-bottom:3px;">${iconEmailImg}</td><td valign="middle" style="padding-bottom:3px;"><a href="mailto:${data.email}" style="color:#333;text-decoration:none;">${data.email}</a></td></tr>` : ''}
                                ${data.phone ? `<tr><td width="20" valign="middle" style="padding-bottom:3px;">${iconPhoneImg}</td><td valign="middle" style="padding-bottom:3px;"><a href="tel:${data.phone}" style="color:#333;text-decoration:none;">${data.phone}</a></td></tr>` : ''}
                                ${data.address ? `<tr><td width="20" valign="middle" style="padding-bottom:3px;">${iconAddrImg}</td><td valign="middle" style="padding-bottom:3px;"><a href="${mapUrl}" target="_blank" style="color:#333;text-decoration:none;">${data.address}</a></td></tr>` : ''}
                                ${data.website ? `<tr><td width="20" valign="middle" style="padding-bottom:2px;">${iconWebImg}</td><td valign="middle" style="padding-bottom:2px;"><a href="${webHref}" style="color:#333;text-decoration:none;">${data.website.replace(/^https?:\/\//, '')}</a></td></tr>` : ''}
                             </table>
                             
                             <table cellpadding="0" cellspacing="0" border="0">
                                <tr>
                                    <td valign="middle" style="padding-right: 15px;">${iconsHtml}</td>
                                    <td valign="middle">${reviewBtnHtml}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>`;
            }

            const borderStyle = data.showBorder ? 'border: 1px solid #eeeeee; border-radius: 12px;' : '';

            return `
            <table width="100%" cellpadding="0" cellspacing="0" border="0" align="left" style="width: 100%; max-width: 650px; background-color: #ffffff; ${borderStyle} margin: 0;">
                <tr>
                    <td style="padding: 20px;">
                        ${innerContent}
                    </td>
                </tr>
            </table>`;
        }

        function getFormData() {
            return {
                template: document.getElementById('styleTemplate').value,
                name: document.getElementById('name').value,
                job: document.getElementById('job').value,
                tagline: document.getElementById('tagline').value,
                email: document.getElementById('email').value,
                phone: document.getElementById('phone').value,
                address: document.getElementById('address').value,
                company: document.getElementById('company').value,
                website: document.getElementById('website').value,
                logoUrl: document.getElementById('logoUrl').value,
                primaryColor: document.getElementById('primaryColor').value,
                fontSize: document.getElementById('fontSize').value,
                logoWidth: document.getElementById('logoWidth').value,
                googleReviewUrl: document.getElementById('googleReviewUrl').value,
                showBorder: document.getElementById('showBorder').checked
            };
        }

        function updateSignature() { 
            const data = getFormData();
            document.getElementById('logoWidthDisplay').innerText = data.logoWidth + "px";
            document.getElementById('preview-output').innerHTML = generateHTML(data); 
        }
        function resetForm() { document.querySelectorAll('input, textarea').forEach(i => { if(i.type !== 'color' && i.type !== 'number' && i.type !== 'range' && i.type !== 'checkbox') i.value = ''; }); document.getElementById('logoPreview').innerText = ""; customLinks = []; renderLinkInputs(); updateSignature(); }
        async function copyToClipboard() { const html = generateHTML(getFormData()); try { await navigator.clipboard.write([new ClipboardItem({ 'text/html': new Blob([html], { type: 'text/html' }), 'text/plain': new Blob([html], { type: 'text/plain' }) })]); alert('Copié !'); } catch (err) { navigator.clipboard.writeText(html); alert('Copié (HTML brut).'); } }

        fetchProjects(); updateSignature();
    </script>
</body>
</html>