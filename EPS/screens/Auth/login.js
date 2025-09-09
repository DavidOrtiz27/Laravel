import {
  StyleSheet,
  Text,
  Image,
  TouchableOpacity,
  Alert,
  ScrollView,
} from "react-native";
import TextInputComponent from "../../components/inputComponent";
import { useNavigation } from "@react-navigation/native";

export default function Login() {
  const navigation = useNavigation();

  return (
    <ScrollView
      contentContainerStyle={styles.container}
      keyboardShouldPersistTaps="handled"
    >
      <Image source={require("../../assets/mapu.png")} style={styles.logo} />

      {/* Título principal */}
      <Text style={styles.title}>Sistema de Gestión Médica</Text>

      {/* Subtítulo */}
      <Text style={styles.subtitle}>Iniciar Sesión</Text>

      {TextInputComponent("Documento", "Ingrese su documento")}
      {TextInputComponent("Contraseña", "Ingrese su contraseña")}

      <Text style={styles.textLink}>Recuperar Contraseña</Text>

      <TouchableOpacity
        style={styles.button}
        onPress={() => Alert.alert("Iniciar Sesión", "Botón presionado")}
      >
        <Text style={styles.buttonText}>Iniciar Sesión</Text>
      </TouchableOpacity>

      <Text
        style={styles.textCreate}
        onPress={() => navigation.navigate("Register")}
      >
        ¿Aún no tienes cuenta?
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
    minHeight: "100%",
    paddingHorizontal: 54,
    paddingVertical: 32,
  },
  logo: {
    width: 220,
    height: 220,
    marginBottom: 10,
    resizeMode: "contain",
  },
  title: {
    fontSize: 34, // más grande
    fontWeight: "700",
    marginBottom: 12,
    textAlign: "center",
    color: "#000",
    top: -40,
  },
  subtitle: {
    fontSize: 22, // un poco más pequeño
    fontWeight: "500",
    marginBottom: 28,
    textAlign: "center",
    color: "#333",
  },
  textLink: {
    color: "#007BFF",
    fontSize: 16, // más pequeño
    marginTop: 12,
    textAlign: "right",
    alignSelf: "stretch",
    marginRight: 4,
  },
  textCreate: {
    color: "#007BFF",
    fontSize: 16, // mismo tamaño que link
    marginTop: 60,
    textAlign: "center",
    padding: 20,
  },
  button: {
    backgroundColor: "#007BFF",
    paddingVertical: 14,
    paddingHorizontal: 40,
    borderRadius: 8,
    marginTop: 24,
    width: "100%",
    alignItems: "center",
    maxWidth: 350,
  },
  buttonText: {
    color: "#fff",
    fontSize: 18, // se mantiene
    fontWeight: "bold",
  },
});
