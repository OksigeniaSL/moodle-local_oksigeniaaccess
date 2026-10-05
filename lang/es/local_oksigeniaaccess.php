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
 * Language strings for local_oksigeniaaccess (Spanish).
 *
 * @package    local_oksigeniaaccess
 * @copyright  2026 Oksigenia <dev@oksigenia.cc>
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['allow_nudge'] = 'Permitir que los visitantes muevan el botón';
$string['allow_nudge_desc'] = 'Los visitantes pueden recolocar el botón flotante dentro de unos límites, arrastrándolo o con las teclas de flecha cuando tiene el foco. La posición se recuerda en su navegador y el botón nunca puede quedar fuera de la pantalla. Una ayuda de accesibilidad para campos visuales reducidos, lupas de pantalla o uso con una sola mano.';
$string['btn_bg'] = 'Fondo en reposo';
$string['btn_bg_desc'] = 'Color de fondo del botón flotante en reposo. Por defecto <code>#000</code>.';
$string['btn_h_bg'] = 'Fondo al pasar el ratón';
$string['btn_h_bg_desc'] = 'Color de fondo del botón flotante al pasar el ratón por encima. Por defecto <code>#fff</code>.';
$string['btn_h_icon'] = 'Color del icono al pasar el ratón';
$string['btn_h_icon_desc'] = 'Color del icono dentro del botón flotante al pasar el ratón por encima. Por defecto <code>#000</code>.';
$string['btn_icon'] = 'Color del icono en reposo';
$string['btn_icon_desc'] = 'Color del icono dentro del botón flotante en reposo. Por defecto <code>#fff</code>.';
$string['btn_size'] = 'Tamaño del botón';
$string['btn_size_desc'] = 'Tamaño CSS (con unidad, p. ej. <code>60px</code>) del botón flotante. Por defecto <code>55px</code>. Déjelo vacío para usar el valor por defecto.';
$string['controls'] = 'Controles mostrados a los visitantes';
$string['controls_desc'] = 'Marque los controles que ofrece el panel de accesibilidad. Con todos marcados (la opción por defecto) se muestran los 17. Desmarque los que no procedan en su campus. Si desmarca todos, se vuelven a mostrar todos: un panel sin controles no tendría sentido.';
$string['ctrl_big_cursor'] = 'Cursor grande';
$string['ctrl_big_targets'] = 'Áreas grandes';
$string['ctrl_colorblind'] = 'Filtros de daltonismo';
$string['ctrl_contrast'] = 'Alto contraste';
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
$string['disclaimer_html'] = '<p>Oksigenia Access ofrece al visitante 17 controles y 4 perfiles predefinidos para adaptar el sitio a sus necesidades: tamaño del texto, contraste, fuente para dislexia, modos de daltonismo, guía de lectura, máscara de lectura, cursor grande, áreas grandes, pausa de animaciones, entre otros. Las preferencias de los invitados se quedan en su navegador. Las de los usuarios identificados se guardan también en su cuenta de Moodle para que les sigan entre dispositivos, salvo que lo desactive más abajo.</p><p><strong>Esta extensión no audita ni corrige automáticamente el contenido de su Moodle.</strong> Cumplir con las WCAG 2.1, la Directiva (UE) 2016/2102, el European Accessibility Act 2025 o el RD 1112/2018 requiere trabajo editorial en sus cursos: texto alternativo en las imágenes, transcripciones de los vídeos, contraste de colores, semántica HTML correcta, formularios etiquetados, navegación por teclado, etc. Nada de eso lo arregla un widget flotante.</p>';
$string['enabled'] = 'Activar el panel de accesibilidad';
$string['enabled_desc'] = 'Si está activado, el panel flotante de accesibilidad se inserta en todas las páginas de este sitio.';
$string['excluded_course_ids'] = 'ID de los cursos excluidos';
$string['excluded_course_ids_desc'] = 'Lista de ID de curso, separados por comas o espacios, en los que el panel NO debe insertarse (p. ej. <code>12, 34, 78</code>). Útil para cursos concretos con sus propias ayudas de accesibilidad o herramientas de terceros. Déjelo vacío para insertarlo en todos los cursos.';
$string['hide_on_admin'] = 'Ocultar en las páginas de administración';
$string['hide_on_admin_desc'] = 'Si está activado, el panel no se inserta en las URL de Administración del sitio (/admin/...). Se recomienda activarlo: los administradores usan sus propias herramientas de accesibilidad y el panel puede solaparse con la interfaz de configuración.';
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
$string['locale_mode_auto'] = 'Automático (seguir el idioma de Moodle)';
$string['locale_mode_desc'] = '"Automático" sigue el idioma actual de Moodle; "Forzar" ignora Moodle y usa el idioma que usted elija.';
$string['locale_mode_force'] = 'Forzar un idioma concreto';
$string['locale_nl'] = 'Neerlandés (nl)';
$string['locale_override'] = 'Idioma forzado';
$string['locale_override_desc'] = 'Solo se usa cuando "Origen del idioma" está en "Forzar un idioma concreto".';
$string['locale_sv'] = 'Sueco (sv)';
$string['oksigeniaaccess:view'] = 'Ver el panel de accesibilidad';
$string['pluginname'] = 'Panel de accesibilidad (Oksigenia Access)';
$string['pos_bottom_center'] = 'Abajo al centro';
$string['pos_bottom_left'] = 'Abajo a la izquierda';
$string['pos_bottom_right'] = 'Abajo a la derecha';
$string['pos_inherit'] = 'Heredar de escritorio';
$string['pos_mid_center'] = 'Centro';
$string['pos_mid_left'] = 'Centro a la izquierda';
$string['pos_mid_right'] = 'Centro a la derecha';
$string['pos_top_center'] = 'Arriba al centro';
$string['pos_top_left'] = 'Arriba a la izquierda';
$string['pos_top_right'] = 'Arriba a la derecha';
$string['position'] = 'Posición del botón (escritorio)';
$string['position_desc'] = 'Dónde aparece el botón flotante en pantallas de más de 768 px de ancho.';
$string['position_mobile'] = 'Posición del botón (móvil)';
$string['position_mobile_desc'] = 'Posición alternativa opcional para pantallas de hasta 768 px. Útil si en el móvil la posición de escritorio tapa los botones de llamada a la acción. Déjelo en "Heredar de escritorio" para usar la misma posición que en escritorio.';
$string['privacy:metadata:preference:state'] = 'Los ajustes que un usuario identificado elige en el panel de accesibilidad (tamaño del texto, contraste, fuentes y el resto), para que le sigan entre dispositivos. Los de los invitados se quedan en su navegador y nunca llegan al servidor.';
$string['privacy:preference:state'] = 'Ajustes del panel de accesibilidad';
$string['scope'] = 'Alcance por página';
$string['scope_all'] = 'Todas las páginas';
$string['scope_desc'] = 'Regla general sobre dónde insertar el panel.';
$string['scope_no_login'] = 'Todas las páginas excepto acceso y registro';
$string['settings_appearance'] = 'Apariencia';
$string['settings_behaviour'] = 'Comportamiento';
$string['settings_colors'] = 'Apariencia del botón';
$string['settings_colors_desc'] = 'Personalice el botón flotante para que combine con el tema de su Moodle. Deje vacío cualquier campo para usar el valor por defecto incluido en el componente web. Los colores son valores de color CSS: hexadecimal (<code>#00d4ff</code>), <code>rgb()</code>, <code>hsl()</code> o un nombre de color.';
$string['settings_controls'] = 'Controles y perfiles';
$string['settings_controls_desc'] = 'Elija qué controles de accesibilidad y accesos directos a perfiles ofrece el panel a los visitantes.';
$string['settings_general'] = 'General';
$string['settings_scope'] = 'Visibilidad y alcance';
$string['show_presets'] = 'Mostrar accesos directos a perfiles';
$string['show_presets_desc'] = 'Los perfiles de un solo toque (baja visión, dislexia, motor, sin distracciones) que aparecen sobre los controles individuales. Un perfil se oculta automáticamente cuando la selección le deja menos de dos de sus controles.';
$string['syncprefs'] = 'Guardar los ajustes del panel en la cuenta del usuario';
$string['syncprefs_desc'] = 'Los usuarios identificados encuentran sus ajustes del panel en cualquier dispositivo: se guardan en su cuenta de Moodle además de en el navegador. Los invitados los guardan solo en su navegador. Desactívelo para que los ajustes de todos queden solo en el navegador.';
$string['trigger_icon'] = 'Icono del botón';
$string['trigger_icon_desc'] = 'Icono que se muestra en el botón flotante.';
$string['trigger_zindex'] = 'z-index del botón flotante';
$string['trigger_zindex_desc'] = 'Valor CSS z-index del botón flotante. Déjelo vacío para usar el valor por defecto del componente web (<code>9999999</code>). Indique un número entero positivo para cambiarlo; súbalo si otro elemento flotante tapa el botón (botón de volver arriba del tema, burbuja de chat, banner de cookies...). Desde la v0.3.0 se aplica mediante la variable CSS <code>--oks-z</code> del componente web, con el mismo resultado en todos los navegadores.';
