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
 * Las claves se ordenan alfabéticamente para cumplir con el sniff
 * LangFilesOrdering de Moodle.
 *
 * @package    local_oksigeniaaccess
 * @copyright  2026 Oksigenia <dev@oksigenia.cc>
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['allow_nudge'] = 'Permitir mover el botón';
$string['allow_nudge_desc'] = 'El visitante puede recolocar el botón flotante dentro de unos límites — arrastrándolo o con las flechas del teclado cuando tiene el foco. La posición se recuerda en su navegador y el botón nunca puede perderse fuera de la pantalla. Una ayuda de accesibilidad para campos visuales reducidos, lupas de pantalla o uso con una sola mano.';
$string['btn_bg'] = 'Fondo en reposo';
$string['btn_bg_desc'] = 'Color de fondo del botón en reposo. Por defecto <code>#000</code>.';
$string['btn_h_bg'] = 'Fondo en hover';
$string['btn_h_bg_desc'] = 'Color de fondo del botón al pasar el ratón. Por defecto <code>#fff</code>.';
$string['btn_h_icon'] = 'Color del icono en hover';
$string['btn_h_icon_desc'] = 'Color del icono dentro del botón al pasar el ratón. Por defecto <code>#000</code>.';
$string['btn_icon'] = 'Color del icono en reposo';
$string['btn_icon_desc'] = 'Color del icono dentro del botón en reposo. Por defecto <code>#fff</code>.';
$string['btn_size'] = 'Tamaño del botón';
$string['btn_size_desc'] = 'Tamaño CSS (con unidad, p. ej. <code>60px</code>) del botón flotante. Por defecto <code>55px</code>. Déjalo vacío para usar el default.';
$string['controls'] = 'Controles mostrados al visitante';
$string['controls_desc'] = 'Marca los controles que ofrece el panel. Todos marcados (lo predeterminado) muestra los 17. Desmarca los que no apliquen a tu campus. Desmarcar todos restablece a todos — un panel sin controles no tendría sentido.';
$string['ctrl_big_cursor'] = 'Cursor grande';
$string['ctrl_big_targets'] = 'Áreas grandes';
$string['ctrl_colorblind'] = 'Daltonismo';
$string['ctrl_contrast'] = 'Contraste';
$string['ctrl_dyslexia_font'] = 'Fuente para dislexia';
$string['ctrl_focus'] = 'Resaltar foco';
$string['ctrl_grayscale'] = 'Escala de grises';
$string['ctrl_hide_images'] = 'Ocultar imágenes';
$string['ctrl_highlight_links'] = 'Resaltar enlaces';
$string['ctrl_letter_spacing'] = 'Espaciado entre letras';
$string['ctrl_line_height'] = 'Interlineado';
$string['ctrl_pause_anim'] = 'Pausar animaciones';
$string['ctrl_readable_font'] = 'Fuente legible';
$string['ctrl_reading_guide'] = 'Guía de lectura';
$string['ctrl_reading_mask'] = 'Máscara de lectura';
$string['ctrl_text_align'] = 'Alineación del texto';
$string['ctrl_text_size'] = 'Tamaño del texto';
$string['disclaimer_heading'] = 'Aviso de cumplimiento';
$string['disclaimer_html'] = '<p>Oksigenia Access da al visitante 17 controles y 4 perfiles predefinidos para adaptar el sitio a sus necesidades: tamaño de texto, contraste, fuente para dislexia, modos de daltonismo, guía de lectura, máscara de lectura, cursor grande, áreas grandes, pausa de animaciones, entre otros. Las preferencias se guardan solo en el navegador del visitante, nunca en el servidor.</p><p><strong>Este plugin no audita ni corrige automáticamente el contenido de tu Moodle.</strong> Cumplir con WCAG 2.1, la Directiva (UE) 2016/2102, el European Accessibility Act 2025 o el RD 1112/2018 requiere trabajo editorial sobre tus cursos: alt text en imágenes, transcripciones de vídeo, contraste de colores, semántica HTML correcta, etiquetado de formularios, navegación por teclado, etc. Nada de eso lo arregla un widget flotante.</p>';
$string['enabled'] = 'Activar panel de accesibilidad';
$string['enabled_desc'] = 'Cuando está activado, el panel flotante de accesibilidad se inyecta en todas las páginas del sitio.';
$string['excluded_course_ids'] = 'IDs de cursos excluidos';
$string['excluded_course_ids_desc'] = 'Lista de IDs de curso separados por coma o espacio donde el panel NO debe inyectarse (p. ej. <code>12, 34, 78</code>). Útil para cursos con sus propias herramientas de accesibilidad o de terceros. Vacío = inyectar en todos los cursos.';
$string['hide_on_admin'] = 'Ocultar en páginas de administración';
$string['hide_on_admin_desc'] = 'Si está activo, el panel NO se inyecta en URLs de Administración del sitio (/admin/...). Recomendado: los administradores ya tienen sus herramientas de accesibilidad y el panel puede solapar la UI de ajustes.';
$string['icon_eye'] = 'Ojo';
$string['icon_porthole'] = 'Ojo de buey (glifo enmarcado)';
$string['icon_universal'] = 'Acceso universal';
$string['icon_vitruvian'] = 'Hombre de Vitruvio (por defecto)';
$string['icon_wheelchair'] = 'Silla de ruedas';
$string['locale_de'] = 'Alemán (de)';
$string['locale_en'] = 'Inglés (en)';
$string['locale_es'] = 'Español (es)';
$string['locale_fr'] = 'Francés (fr)';
$string['locale_gn'] = 'Guaraní (gn)';
$string['locale_it'] = 'Italiano (it)';
$string['locale_mode'] = 'Origen del idioma';
$string['locale_mode_auto'] = 'Auto (seguir idioma de Moodle)';
$string['locale_mode_desc'] = 'Auto sigue el idioma actual de Moodle; Forzar ignora Moodle y usa el idioma que elijas.';
$string['locale_mode_force'] = 'Forzar un idioma concreto';
$string['locale_nl'] = 'Neerlandés (nl)';
$string['locale_override'] = 'Idioma forzado';
$string['locale_override_desc'] = 'Solo se usa cuando "Origen del idioma" está en "Forzar".';
$string['locale_sv'] = 'Sueco (sv)';
$string['oksigeniaaccess:view'] = 'Ver el panel de accesibilidad';
$string['pluginname'] = 'Oksigenia Access';
$string['pos_bottom_center'] = 'Abajo centro';
$string['pos_bottom_left'] = 'Abajo izquierda';
$string['pos_bottom_right'] = 'Abajo derecha';
$string['pos_inherit'] = 'Heredar de escritorio';
$string['pos_mid_center'] = 'Centro';
$string['pos_mid_left'] = 'Centro izquierda';
$string['pos_mid_right'] = 'Centro derecha';
$string['pos_top_center'] = 'Arriba centro';
$string['pos_top_left'] = 'Arriba izquierda';
$string['pos_top_right'] = 'Arriba derecha';
$string['position'] = 'Posición del botón (escritorio)';
$string['position_desc'] = 'Dónde aparece el botón flotante en pantallas de más de 768 px.';
$string['position_mobile'] = 'Posición del botón (móvil)';
$string['position_mobile_desc'] = 'Sobrescritura opcional para pantallas de hasta 768 px. Útil si la posición de escritorio tapa CTAs móviles. Déjalo en "Heredar" para usar la misma que escritorio.';
$string['privacy:metadata'] = 'El plugin Oksigenia Access no almacena ni transmite datos personales. Las preferencias del visitante para el panel de accesibilidad se guardan únicamente en el localStorage de su navegador y nunca llegan al servidor.';
$string['scope'] = 'Alcance por página';
$string['scope_all'] = 'Todas las páginas';
$string['scope_desc'] = 'Regla amplia de dónde inyectar el panel.';
$string['scope_no_login'] = 'Todas excepto login/alta';
$string['settings_appearance'] = 'Aspecto';
$string['settings_behaviour'] = 'Comportamiento';
$string['settings_colors'] = 'Personalización del botón';
$string['settings_colors_desc'] = 'Personaliza el botón flotante para que combine con el tema de tu Moodle. Deja vacío cualquier campo para usar el valor por defecto del web component. Los colores son valores CSS: hex (<code>#00d4ff</code>), <code>rgb()</code>, <code>hsl()</code> o un color con nombre.';
$string['settings_general'] = 'General';
$string['settings_scope'] = 'Visibilidad y alcance';
$string['trigger_icon'] = 'Icono del botón';
$string['trigger_icon_desc'] = 'Icono mostrado en el botón flotante.';
$string['trigger_zindex'] = 'z-index del botón flotante';
$string['trigger_zindex_desc'] = 'Valor CSS z-index del botón flotante. Déjalo vacío para usar el default del web component (<code>9999999</code>). Si pones un entero positivo, sobrescribe — súbelo si el botón queda tapado por otro widget flotante (scrolltop del theme, burbuja de chat, banner de cookies...). Desde la v0.3.0 usa la variable CSS <code>--oks-z</code> del web component — determinista en todos los navegadores.';
