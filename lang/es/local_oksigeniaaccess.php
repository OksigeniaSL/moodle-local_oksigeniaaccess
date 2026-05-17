<?php
// This file is part of Moodle - https://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <https://www.gnu.org/licenses/>.

/**
 * Cadenas de idioma para local_oksigeniaaccess (español).
 *
 * @package    local_oksigeniaaccess
 * @copyright  2026 Oksigenia SL <dev@oksigenia.com>
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['pluginname'] = 'Oksigenia Access';

$string['settings_general']        = 'General';
$string['enabled']                 = 'Activar panel de accesibilidad';
$string['enabled_desc']            = 'Cuando está activado, el panel flotante de accesibilidad se inyecta en todas las páginas del sitio.';

$string['settings_appearance']     = 'Aspecto';
$string['position']                = 'Posición del botón (escritorio)';
$string['position_desc']           = 'Dónde aparece el botón flotante en pantallas de más de 768 px.';
$string['position_mobile']         = 'Posición del botón (móvil)';
$string['position_mobile_desc']    = 'Sobrescritura opcional para pantallas de hasta 768 px. Útil si la posición de escritorio tapa CTAs móviles. Déjalo en "Heredar" para usar la misma que escritorio.';
$string['trigger_icon']            = 'Icono del botón';
$string['trigger_icon_desc']       = 'Icono mostrado en el botón flotante.';

$string['settings_scope']          = 'Visibilidad y alcance';
$string['hide_on_admin']           = 'Ocultar en páginas de administración';
$string['hide_on_admin_desc']      = 'Si está activo, el panel NO se inyecta en URLs de Administración del sitio (/admin/...). Recomendado: los administradores ya tienen sus herramientas de accesibilidad y el panel puede solapar la UI de ajustes.';
$string['excluded_course_ids']     = 'IDs de cursos excluidos';
$string['excluded_course_ids_desc'] = 'Lista de IDs de curso separados por coma o espacio donde el panel NO debe inyectarse (p. ej. <code>12, 34, 78</code>). Útil para cursos con sus propias herramientas de accesibilidad o de terceros. Vacío = inyectar en todos los cursos.';
$string['trigger_zindex']          = 'z-index del botón flotante';
$string['trigger_zindex_desc']     = 'Valor CSS z-index del botón flotante. Súbelo si el botón queda tapado por otro widget flotante (botón scrolltop del theme, burbuja de chat, banner de cookies...). Por defecto 99999.';

// Etiqueta de la capability (visible en Admin del sitio → Usuarios → Permisos → Definir roles).
$string['oksigeniaaccess:view']    = 'Ver el panel de accesibilidad';

// Aviso de cumplimiento mostrado arriba de la página de ajustes.
$string['disclaimer_heading']      = 'Aviso de cumplimiento';
$string['disclaimer_html']         = '<p>Oksigenia Access da al visitante 15 controles para adaptar el sitio a sus necesidades: tamaño de texto, contraste, fuente para dislexia, modos de daltonismo, guía de lectura, cursor grande, pausa de animaciones, entre otros. Las preferencias se guardan solo en el navegador del visitante, nunca en el servidor.</p><p><strong>Este plugin no audita ni corrige automáticamente el contenido de tu Moodle.</strong> Cumplir con WCAG 2.1, la Directiva (UE) 2016/2102, el European Accessibility Act 2025 o el RD 1112/2018 requiere trabajo editorial sobre tus cursos: alt text en imágenes, transcripciones de vídeo, contraste de colores, semántica HTML correcta, etiquetado de formularios, navegación por teclado, etc. Nada de eso lo arregla un widget flotante.</p><p>Si necesitas evidencia documental firmada para una auditoría oficial, ofrecemos como servicio independiente la auditoría profesional + certificado en <a href="https://sponsor.oksigenia.com" target="_blank" rel="noopener noreferrer">sponsor.oksigenia.com</a>.</p>';

$string['settings_behaviour']      = 'Comportamiento';
$string['locale_mode']             = 'Origen del idioma';
$string['locale_mode_desc']        = 'Auto sigue el idioma actual de Moodle; Forzar ignora Moodle y usa el idioma que elijas.';
$string['locale_mode_auto']        = 'Auto (seguir idioma de Moodle)';
$string['locale_mode_force']       = 'Forzar un idioma concreto';
$string['locale_override']         = 'Idioma forzado';
$string['locale_override_desc']    = 'Solo se usa cuando "Origen del idioma" está en "Forzar".';
$string['scope']                   = 'Alcance por página';
$string['scope_desc']              = 'Regla amplia de dónde inyectar el panel.';
$string['scope_all']               = 'Todas las páginas';
$string['scope_no_login']          = 'Todas excepto login/alta';

// Valores de posición.
$string['pos_top_left']            = 'Arriba izquierda';
$string['pos_top_right']           = 'Arriba derecha';
$string['pos_mid_left']            = 'Centro izquierda';
$string['pos_mid_right']           = 'Centro derecha';
$string['pos_bottom_left']         = 'Abajo izquierda';
$string['pos_bottom_right']        = 'Abajo derecha';
$string['pos_inherit']             = 'Heredar de escritorio';

// Iconos del botón.
$string['icon_vitruvian']          = 'Hombre de Vitruvio (por defecto)';
$string['icon_wheelchair']         = 'Silla de ruedas';
$string['icon_eye']                = 'Ojo';
$string['icon_universal']          = 'Acceso universal';

// Idiomas soportados por el web component.
$string['locale_es']               = 'Español (es)';
$string['locale_en']               = 'Inglés (en)';
$string['locale_gn']               = 'Guaraní (gn)';
$string['locale_fr']               = 'Francés (fr)';
$string['locale_it']               = 'Italiano (it)';
$string['locale_de']               = 'Alemán (de)';
$string['locale_nl']               = 'Neerlandés (nl)';
$string['locale_sv']               = 'Sueco (sv)';

// Privacidad: el plugin no almacena ni transmite datos personales.
$string['privacy:metadata'] = 'El plugin Oksigenia Access no almacena ni transmite datos personales. Las preferencias del visitante para el panel de accesibilidad se guardan únicamente en el localStorage de su navegador y nunca llegan al servidor.';
