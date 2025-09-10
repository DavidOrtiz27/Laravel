import {
  StyleSheet,
  Text,
  Image,
  TouchableOpacity,
  Alert,
  ScrollView,
  View,
} from "react-native";
import TextInputComponent from "../../components/inputComponent";
import { useNavigation } from "@react-navigation/native";

export default function Register() {
  const navigation = useNavigation();

  return (
    <ScrollView
      contentContainerStyle={styles.container}
      keyboardShouldPersistTaps="handled"
    >
      {/* Logo y título */}
      <View style={styles.header}>
        <Image source={require("../../assets/mapu.png")} style={styles.logo} />
        <Text style={styles.title}>Sistema de Gestión Médica</Text>
        <Text style={styles.subtitle}>Crear Cuenta</Text>
      </View>

      {/* Formulario */}
      <View style={styles.form}>
        {TextInputComponent("Nombre Completo", "Ingrese su nombre completo")}
        {TextInputComponent(
          "Correo Electrónico",
          "Ingrese su correo electrónico",
          "email-address"
        )}
        {TextInputComponent("Contraseña", "Ingrese su contraseña",)}
        {TextInputComponent(
          "Confirmar Contraseña",
          "Confirme su contraseña",
        )}
      </View>

      {/* Botón */}
      <TouchableOpacity
        style={styles.button}
        onPress={() => Alert.alert("Crear Cuenta", "Botón presionado")}
      >
        <Text style={styles.buttonText}>Crear Cuenta</Text>
      </TouchableOpacity>

      {/* Link para iniciar sesión */}
      <Text
        style={styles.textCreate}
        onPress={() => navigation.navigate("Login")}
      >
        ¿Ya tienes una cuenta?
      </Text>
    </ScrollView>
  );
}

const styles = StyleSheet.create({
  container: {
    flexGrow: 1,
    backgroundColor: "#DDE6ED",
    alignItems: "center",
    justifyContent: "center",
    paddingHorizontal: 30,
  },
  header: {
    alignItems: "center",
    marginTop: -70,
  },
  logo: {
    width: 180,
    height: 180,
    marginBottom: 10,
    resizeMode: "contain",
  },
  title: {
    fontSize: 26,
    fontWeight: "700",
    color: "#222",
    marginBottom: 6,
    textAlign: "center",
  },
  subtitle: {
    fontSize: 18,
    color: "#555",
    marginBottom: 20,
    textAlign: "center",
  },
  form: {
    top: -20,
    width: "100%",
    maxWidth: 350,
    marginBottom: 20,
  },
  button: {
    backgroundColor: "#007BFF",
    paddingVertical: 14,
    borderRadius: 10,
    marginTop: 10,
    width: "100%",
    maxWidth: 350,
    alignItems: "center",
    shadowColor: "#000",
    shadowOffset: { width: 0, height: 2 },
    shadowOpacity: 0.2,
    shadowRadius: 3,
    elevation: 3,
    top: -30,
  },
  buttonText: {
    color: "#fff",
    fontSize: 16,
    fontWeight: "600",
  },
  textCreate: {
    color: "#007BFF",
    fontSize: 15,
    marginTop: 24,
    textAlign: "center",
    top: -20,
  },
});
