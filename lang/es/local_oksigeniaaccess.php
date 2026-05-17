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

$string['settings_behaviour']      = 'Comportamiento';
$string['locale_mode']             = 'Origen del idioma';
$string['locale_mode_desc']        = 'Auto sigue el idioma actual de Moodle; Forzar ignora Moodle y usa el idioma que elijas.';
$string['locale_mode_auto']        = 'Auto (seguir idioma de Moodle)';
$string['locale_mode_force']       = 'Forzar un idioma concreto';
$string['locale_override']         = 'Idioma forzado';
$string['locale_override_desc']    = 'Solo se usa cuando "Origen del idioma" está en "Forzar".';
$string['scope']                   = 'Mostrar en';
$string['scope_desc']              = 'Dónde inyectar el panel.';
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
